<?php

include "database.php";

$localhost = 'localhost:3806';
$username = 'root';
$password = '';
$database = 'products';

class scrap{
    const D2E = 30.90; // dollar to egp
    const SYBMOLSTODELETE = [0,1,2,3,4,5,6,7,8,9,'!','"','#','%','&',"'",'(',')','*','+',',','-','.','/',':',';','<','>','=','?','@','[',']','\\','^','_','{','}','|','~'];
    const SKIPCHARLIST = ["<",">","!","'","/","\\","_","%",'-','"',",","&"]; // to avoid sql injection
    private $curl_connection_result;
    private function connect($url){
        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36',
            'Accept: ect,rtt,downlink,device-memory,sec-ch-device-memory,viewport-width,sec-ch-viewport-width,dpr,sec-ch-dpr',
            'content-encoding: gzip',
            'Accept-Language: en-US',
            'Cache-Control: no-cache',
            'content-type: text/html;charset=UTF-8',
            'content-language: en-US',
        ];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $exec = curl_exec($ch);
        $http_code = (string) curl_getinfo($ch,CURLINFO_HTTP_CODE);
        // curl_close($ch);
        $ccr = array(
            'response' => $http_code ,
            'html' => $exec,
        );
        $this->curl_connection_result = $ccr;
    }
    public function amazon($product){
        $product_after_edit = str_replace(' ','+',$product);
        $url = "https://www.amazon.eg/s?k=$product_after_edit&language=en";
        $this->connect($url); //Estaplish a Connection
        if($this->curl_connection_result != NULL){
            if($this->curl_connection_result['response'] == '200'){
                // echo 'passed amazon.'.'<br>';
                $dom = new DomDocument();
                @$dom->loadHTML($this->curl_connection_result['html']);
                $finder = new DomXPath($dom);
                $classname="s-result-item";
                $ml = "a-link-normal s-no-outline";
                $mis = "s-image";
                $md = "a-size-base-plus";
                $mpw = "a-price-whole";
                $mps = "a-price-symbol";
                $mrt = "a-icon-alt";
                $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
                // echo 'nodes :' . count($nodes) . '<br>';
                for($i=0;$i<count($nodes);$i++){
                    //new dom
                    $newdom = new DOMDocument();
                    @$newdom->loadHTML('<?xml encoding="utf-8" ?>' . $dom->saveHTML($nodes->item($i)));
                    $newfinder = new DOMXPath($newdom);
                    // setvariables"//*[@class='$mpw']"
                    $main_link = $newfinder->query("//a[contains(concat(' ', normalize-space(@class), ' '), '$ml')]");
                    $main_img_src = $newfinder->query("//img[@class='$mis']");
                    $main_description = $newfinder->query("//span[contains(concat(' ', normalize-space(@class), ' '), '$md')]");
                    $main_price_whole = $newfinder->query("//span[contains(concat(' ', normalize-space(@class), ' '), '$mpw')]");
                    $main_price_symbol = $newfinder->query("//span[contains(concat(' ', normalize-space(@class), ' '), '$mps')]");
                    $main_rating = $newfinder->query("//span[@class='$mrt']");

                    // echo $main_link->length .'-'. $main_img_src->length .'-'. $main_description->length .'-'. $main_price_whole->length .'-'. $main_price_symbol->length .'-'. $main_rating->length . '<br>';
                    if($main_link->length != 0 and $main_img_src->length != 0 and $main_description->length != 0 and $main_price_whole->length != 0 and $main_price_symbol->length != 0){
                        $link = "https://www.amazon.eg" . (string) $main_link[0]->getAttribute('href');
                        $img_src = (string) $main_img_src[0]->getAttribute('src');
                        $description = str_replace(self::SKIPCHARLIST," ",htmlspecialchars((string) $main_description[0]->textContent));
                        $price = (int) filter_var((string) $main_price_whole[0]->textContent,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                        $price_symbol = str_replace(self::SYBMOLSTODELETE," ",htmlspecialchars((string) $main_price_symbol[0]->textContent));
                        $rating =  $main_rating->length != 0 ? (double) filter_var(rtrim($main_rating[0]->textContent,'of 5 stars'),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION):null;
                        // echo 'link: ' . $link .'<br>';
                        // echo 'img_src: ' . $img_src .'<br>';
                        // echo 'description: ' . $description .'<br>';  
                        // echo 'price: ' . $price .'<br>';
                        // echo 'price_symbol: ' . $price_symbol .'<br>';
                        // echo 'raring: ' . $rating . '<br>'; 
                        // echo '#######################################################' . '<br>';
                        $db = new database();
                        $db->connect($GLOBALS['localhost'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
                        $db->exec("INSERT INTO products (product,product_company,product_link,product_imgSrc,product_description,product_price,product_priceSymbol,product_rating) VALUES ('$product','amazon','$link','$img_src','$description',$price,'$price_symbol','$rating')");
                    
                    }
                    
                } 

            } else{
                echo 'amazon access denied !' . '<br>';
            }
        }

    }

    public function jumia($product){
        $product_after_edit = str_replace(' ','+',$product);
        $url = "https://www.jumia.com.eg/catalog/?q=$product_after_edit";
        $this->connect($url); //Estaplish a Connection
        if($this->curl_connection_result != NULL){
            if($this->curl_connection_result['response'] == '200'){
                // echo 'passed jumia.'.'<br>';
                $dom = new DomDocument();
                @$dom->loadHTML($this->curl_connection_result['html']);
                $finder = new DomXPath($dom);
                $classname="prd";
                $ml = "core";
                $mis = "img";
                $md = "name";
                $mpw = "prc";
                $mps = "prc";
                $mr = "stars _s";
                $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), '$classname')]");
                // echo 'nodes :' . count($nodes) . '<br>';
                for($i=0;$i<count($nodes);$i++){
                    //new dom
                    $newdom = new DOMDocument();
                    @$newdom->loadHTML('<?xml encoding="utf-8" ?>' . $dom->saveHTML($nodes->item($i)));
                    $newfinder = new DOMXPath($newdom);
                    // setvariables
                    $main_link = $newfinder->query("//a[@class='$ml']");
                    $main_img_src = $newfinder->query("//img[contains(concat(' ', normalize-space(@class), ' '), '$mis')]");
                    $main_description = $newfinder->query("//*[contains(concat(' ', normalize-space(@class), ' '), '$md')]");
                    $main_price_whole = $newfinder->query("//*[@class='$mpw']");
                    $main_price_symbol = $newfinder->query("//*[@class='$mps']");
                    $main_rating = $newfinder->query("//*[@class='$mr']");
                    // echo $main_link->length .'-'. $main_img_src->length .'-'. $main_description->length .'-'. $main_price_whole->length .'-'. $main_price_symbol->length . '<br>';
                    if($main_link->length !=0 and $main_img_src->length != 0 and $main_description->length != 0 and $main_price_whole->length != 0 and $main_price_symbol->length != 0){
                        $link = "https://www.jumia.com.eg" . (string) $main_link[0]->getAttribute('href');
                        $img_src = (string) $main_img_src[0]->getAttribute('data-src');
                        $description = str_replace(self::SKIPCHARLIST," ",htmlspecialchars((string) $main_description[0]->textContent));
                        $price = (int) filter_var((string) $main_price_whole[0]->textContent,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                        $price_symbol = str_replace(self::SYBMOLSTODELETE," ",htmlspecialchars((string) $main_price_symbol[0]->textContent));
                        $rating =  $main_rating->length != 0 ? (double) filter_var(rtrim($main_rating[0]->textContent,'5'),FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION):null;
                        // echo 'link: ' . $link .'<br>';
                        // echo 'img_src: ' . $img_src .'<br>';
                        // echo 'description: ' . $description .'<br>';  
                        // echo 'price: ' . $price .'<br>';
                        // echo 'price_symbol: ' . $price_symbol .'<br>';
                        // echo 'raring: ' . $rating . '<br>'; 
                        // echo '#######################################################' . '<br>';
                        $db = new database();
                        $db->connect($GLOBALS['localhost'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
                        $db->exec("INSERT INTO products (product,product_company,product_link,product_imgSrc,product_description,product_price,product_priceSymbol,product_rating) VALUES ('$product','jumia','$link','$img_src','$description',$price,'$price_symbol','$rating')");
            
                    }
                    
                } 

            } else{
                echo 'jumia access denied ! ' . '<br>'; 
            }
        }
    }

    public function ebay($product){
        $product_after_edit = str_replace(' ','+',$product);
        $url = "https://www.ebay.com/sch/i.html?_nkw=$product_after_edit";
        $this->connect($url);
        if($this->curl_connection_result != NULL){
            if($this->curl_connection_result['response'] == '200'){
                // echo 'passed ebay.'.'<br>';
                $dom = new DomDocument();
                @$dom->loadHTML($this->curl_connection_result['html']);
                $finder = new DomXPath($dom);
                $classname="s-item__wrapper";
                $ml = "s-item__link";
                $mis = "s-item__image-wrapper";
                $md = "s-item__title";
                $mpw = "s-item__price";
                $mps = "s-item__price";
                $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), '$classname')]");
                // echo 'nodes :' . count($nodes) . '<br>';
                for($i=0;$i<count($nodes);$i++){
                    //new dom
                    $newdom = new DOMDocument();
                    @$newdom->loadHTML('<?xml encoding="utf-8" ?>' . $dom->saveHTML($nodes->item($i)));
                    $newfinder = new DOMXPath($newdom);
                    // setvariables 
                    $main_link = $newfinder->query("//*[@class='$ml']");
                    $main_img_src = $newfinder->query("//*[contains(concat(' ', normalize-space(@class), ' '), '$mis')]");
                    $main_description = $newfinder->query("//*[contains(concat(' ', normalize-space(@class), ' '), '$md')]");
                    $main_price_whole = $newfinder->query("//*[@class='$mpw']");
                    $main_price_symbol = $newfinder->query("//*[@class='$mps']");      
                    // echo $main_link->length .'-'. $main_img_src->length .'-'. $main_description->length .'-'. $main_price_whole->length .'-'. $main_price_symbol->length . '<br>';
                    if($main_link->length and $main_img_src->length != 0 and $main_description->length != 0 and $main_price_whole->length != 0 and $main_price_symbol->length != 0){
                        $link = (string) $main_link[0]->getAttribute('href');
                        $img_src = (string) $main_img_src[0]->firstElementChild->getAttribute('src');
                        $description = str_replace(self::SKIPCHARLIST," ",htmlspecialchars((string) $main_description[0]->textContent));
                        $price = self::D2E * (int) filter_var((string) $main_price_whole[0]->textContent,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                        $price_symbol = "EGP"; //if self::D2E works
                        // $price_symbol = str_replace(self::SYBMOLSTODELETE," ",(string) $main_price_symbol[0]->textContent);
                        
                        // echo 'link: ' . $link .'<br>';
                        // echo 'img_src: ' . $img_src .'<br>';
                        // echo 'description: ' . $description .'<br>';  
                        // echo 'price: ' . $price .'<br>';
                        // echo 'price_symbol: ' . $price_symbol .'<br>';
                        // echo '#######################################################' . '<br>';
                        $db = new database();
                        $db->connect($GLOBALS['localhost'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
                        $db->exec("INSERT INTO products (product,product_company,product_link,product_imgSrc,product_description,product_price,product_priceSymbol) VALUES ('$product','ebay','$link','$img_src','$description',$price,'$price_symbol')");
                    }
                    
                } 

            } else{
                echo 'ebay access denied ! ' . '<br>'; 
            }
        }
    }
}
// $webscraping = new scrap();
// $webscraping->amazon("iphone 14");
// $webscraping->ebay("iphone 13");
// $webscraping->jumia("iphone 11");
