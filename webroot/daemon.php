<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        http_response_code(200);
        $xmlArray = xml2array('php://input', $get_atributes =1, $priority='tag');
        $myfile = fopen("log.txt", "a") or die("Unable to open file!");
        file_put_contents("xmlarray.txt",print_r($xmlArray,true));
	switch (array_keys($xmlArray)[0])
        {
                case "ns2:subscribed":
			if(strpos($xmlArray['ns2:subscribed']['href'],'thingpark/smp/rest/applications/351/subscriptions')!==false){
				//Retrieve user ID
                        	$ID = $xmlArray['ns2:subscribed']['subscriber']['ID'];
				//Connect to DB
                        	$mysqli = new mysqli("localhost", "root", "data123$", "tapps_db");
                        	if ($mysqli->connect_errno) {
                                	fwrite($myfile,"Sorry, this website is experiencing problems. \n");
                        	}
				else{
					fwrite($myfile,"MySQL connection has been properly opened \n");
				}
                        	$sql = "SELECT * FROM users WHERE tp_id = $ID";
				$results = $mysqli->query($sql);
				//Check if user exsist
    				if($results->num_rows===0){
					$ch = curl_init();
                                        //Set url
                                        $url = "https://dx-api.thingpark.com/core/latest/api/subscribers?subscriberId=".$ID;
                                        curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                        // $output contains the output string
                                	fwrite($myfile,"No user corresponds to this ID, let's create one \n");
					//Retrieve subscriber data
					$sql = "SELECT API_KEY FROM users WHERE type = 'vendor'";
					$results = $mysqli->query($sql);
					$rows = $results->fetch_array();
					foreach($rows as $row){
						//Set headers
						$headers = array(
							'Accept: application/json',
							'Authorization: Bearer '. $row,
						);
        					curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        					$output = curl_exec($ch);
						$jsonArray = json_decode($output, true);
                                        	file_put_contents("json.txt",print_r($jsonArray[0],true));
                                        	$name = $jsonArray[0]['name'];
                                        	$org = $jsonArray[0]['organization'];
                                        	$email = $jsonArray[0]['contactEmail'];
                                        	//Push subsriber data into DB
                                        	if(isset($jsonArray[0]['contactEmail'])){
							$sql = "SELECT * FROM users WHERE tpid = $ID";
                                			$results = $mysqli->query($sql);
                                			//Check if user exsist
                                			if($results->num_rows===0){
                                                		$sql = "INSERT INTO users (tp_id,username,name,email,password,org,type) VALUES ($ID ,'$name', '$name','$email','', '$org', 'subscriber')";
                                                		if ($mysqli->query($sql) === TRUE) {
                                                        		fwrite($myfile, "New record created successfully \n");
                                                		}
                                                		else {
                                                        		fwrite($myfile, "Error: " . $sql . "\n" . $mysqli->error);
                                                		}
							}
							else{
								fwrite($myfile,"double notification from thingpark");
							}
                                        	}
					}
        				// close curl resource to free up system resources
        				curl_close($ch);
				}
				else {
                                	fwrite($myfile,"User already exists \n");
                        	}
			}
			else {
				fwrite($myfile, "An application has been bought \n");
			}
			http_response_code(200);
                        break;
                default:
                        http_response_code(200);
                        break;
        }
        fclose($myfile);
}


/*
 * 
 * The following function listen for sync request at the adress : 
 * /tapps-gui/daemon.php?id=<your_device_id>&applist=<some_app_installed_on_your_device>,<some_other>
 * It checks which apps have been bought on the TAS by the owner of the device and returns a list of CDN credentials and URL's
 * corresponding to the apps to install or to delete
 * 
 * 
 */
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    http_response_code(200);
    $stack = array();
    $local_app_list = array();
    $count = 0;
    $data = array();
    if(!empty($_GET["id"])){
        //Getting device id
        $device_id = filter_input(INPUT_GET, 'id');
        //Geting app list
        if(isset($_GET["applist"])){
            //Separating apps
            $remote_app_list = explode(",", filter_input(INPUT_GET, 'applist'));
            //Connecting to db
            $mysqli = new mysqli("localhost", "root", "data123$", "tapps_db");
            if ($mysqli->connect_errno) {
                    //echo "<br>Sorry, this website is experiencing problems";
            }
            else{
                    //echo "<br>MySQL connection has been properly opened";
            }
            //Selecting app id's of the given device on the TAS
            $sql = "SELECT * FROM ownerships WHERE device_id = $device_id";
            $results = $mysqli->query($sql);
            //If the device is not found
            if($results->num_rows===0){
                //echo "unknown device";
            }else{
                //Putting first row in array
                $local_app_list[0] = $results->fetch_array();
                //Putting all rows in array
                while ($local_app_list[$count]!==null){
                    $count++;
                    $local_app_list[$count]=$results->fetch_array();
                }
                $results->free();
                //For each app owned by the device on the tas
                foreach($local_app_list as $app_id){
                    //Getting the app tpid
                    $id = $app_id['tapp_id'];
                    $sql = "SELECT tpid, cdn_uri, cdn_login, cdn_password FROM tapps WHERE id = $id";
                    $results = $mysqli->query($sql);
                    if(!is_bool($results)){
                        $app_tpid = $results->fetch_array();
                        $results->free();
                        array_push($stack,$app_tpid);
                    }
                }
                $local_app_list = $stack;
                foreach ($local_app_list as $app){
                    if(!in_array($app['tpid'], $remote_app_list)){
                        array_push($data, ['id' => $app['tpid'],'cdn_uri' => $app['cdn_uri'],'cdn_login' => $app['cdn_login'],'cdn_password' => $app['cdn_password']]);
                    }
                }
                if(count($data)===0){
                    echo "<br>Up to date";
                }else{
                    header('Content-type: application/json');
                    echo json_encode($data);
                }
            }  
            $mysqli->close();
        }
    }
}



function xml2array($url, $get_attributes = 1, $priority = 'tag')
{
    $contents = "";
    if (!function_exists('xml_parser_create'))
    {
        return array ();
    }
    $parser = xml_parser_create('');
    if (!($fp = @ fopen($url, 'rb')))
    {
        return array ();
    }
    while (!feof($fp))
    {
        $contents .= fread($fp, 8192);
    }
    fclose($fp);
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);
    if (!$xml_values)
        return;
    $xml_array = array ();
    $parents = array ();
    $opened_tags = array ();
    $arr = array ();
    $current = & $xml_array;
    $repeated_tag_index = array ();
    foreach ($xml_values as $data)
    {
        unset ($attributes, $value);
        extract($data);
        $result = array ();
        $attributes_data = array ();
        if (isset ($value))
        {
            if ($priority == 'tag')
                $result = $value;
            else
                $result['value'] = $value;
        }
        if (isset ($attributes) and $get_attributes)
        {
            foreach ($attributes as $attr => $val)
            {
                if ($priority == 'tag')
                    $attributes_data[$attr] = $val;
                else
                    $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }
        if ($type == "open")
        {
            $parent[$level -1] = & $current;
            if (!is_array($current) or (!in_array($tag, array_keys($current))))
            {
                $current[$tag] = $result;
                if ($attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                $current = & $current[$tag];
            }
            else
            {
                if (isset ($current[$tag][0]))
                {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                }
                else
                {
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    );
                    $repeated_tag_index[$tag . '_' . $level] = 2;
                    if (isset ($current[$tag . '_attr']))
                    {
                        $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                        unset ($current[$tag . '_attr']);
                    }
                }
                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                $current = & $current[$tag][$last_item_index];
            }
        }
        elseif ($type == "complete")
        {
            if (!isset ($current[$tag]))
            {
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                if ($priority == 'tag' and $attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
            }
            else
            {
                if (isset ($current[$tag][0]) and is_array($current[$tag]))
                {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    if ($priority == 'tag' and $get_attributes and $attributes_data)
                    {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag . '_' . $level]++;
                }
                else
                {
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    );
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $get_attributes)
                    {
                        if (isset ($current[$tag . '_attr']))
                        {
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset ($current[$tag . '_attr']);
                        }
                        if ($attributes_data)
                        {
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                }
            }
        }
        elseif ($type == 'close')
        {
            $current = & $parent[$level -1];
        }
    }
    return ($xml_array);
}


?>
