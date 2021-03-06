<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        http_response_code(200);
        $xmlArray = xml2array('php://input', $get_atributes =1, $priority='tag');
        //$postData = file_get_contents('php://input');
        //$xmlArray = simplexml_load_string($postData);
        file_put_contents('/home/log.txt', "xmlarray : ".print_r($xmlArray));
        //$xmlArray=XML2Array($postData);
	switch (array_keys($xmlArray)[0])
        {
                case "ns2:subscribed":
			if(strpos($xmlArray['ns2:subscribed']['href'],'thingpark/smp/rest/applications/1501/subscriptions')!==false){
				//Retrieve user ID
                        	$ID = $xmlArray['ns2:subscribed']['subscriber']['ID'];
				//Connect to DB
                        	$mysqli = new mysqli("localhost", "root", "data123$", "tapps_db");
                        	if ($mysqli->connect_errno) {
                                	error_log("Sorry, this website is experiencing problems");
                        	}
				else{
					error_log("MySQL connection has been properly opened");
				}
                        	$sql = "SELECT * FROM users WHERE tpid = $ID";
				$results = $mysqli->query($sql);
				//Check if user exsist
    				if($results->num_rows===0){
					$ch = curl_init();
                                        //Set url
                                        $url = "https://dx-api.thingpark.com/core/latest/api/subscribers?subscriberId=".$ID;
                                        curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                        // $output contains the output string
                                	error_log("No user corresponds to this ID, let's create one");
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
                                                		$sql = "INSERT INTO users (tpid,username,name,email,password,org,type) VALUES ($ID ,'$name', '$name','$email','', '$org', 'subscriber')";
                                                		if ($mysqli->query($sql) === TRUE) {
                                                                    error_log("New record created successfully");
                                                		}
                                                		else {
                                                                    error_log("Error: " . $sql . "\n" . $mysqli->error);
                                                		}
							}
							else{
                                                            error_log("double notification from thingpark");
							}
                                        	}
					}
        				// close curl resource to free up system resources
        				curl_close($ch);
				}
				else {
                                	error_log("User already exists");
                        	}
			}
			else {
				error_log("An application has been bought");
			}
			http_response_code(200);
                        break;
                default:
                        http_response_code(200);
                        break;
        }
}
/*
function XML2Array ($xml)
{
    $array = simplexml_load_string ($xml);
    $newArray = array();
    $array = (array)$array ;
    foreach ($array as $key => $value)
    {
        $value = (array)$value ;
        $newArray [$key] = $value [0] ;
    }
    $newArray = array_map("trim", $newArray);
  return $newArray ;
} 
*/


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
