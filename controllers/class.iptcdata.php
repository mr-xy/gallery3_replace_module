<?php
class iptcdata {

    var $meta = Array();
    var $hasmeta = false;
    var $file = false;

    function __construct($filename) {
        $filename = str_replace(array("flv", "avi", "mpg", "mpeg", "mov", "wmv", "asf", "mts"), 'jpg', $filename);
        $size = getimagesize($filename, $info);
        $this->hasmeta = isset($info["APP13"]);
        if ($this->hasmeta)
            $this->meta = iptcparse($info["APP13"]);
            //keyword-array -> all array-elements to string and filled in [0]-array-postion, because get only takes the [0]-position
            $this->meta["2#025"][0] = implode(", ", $this->meta["2#025"]);
        $this->file = $filename;
    }

    function iptc_make_tag($rec, $data, $value) {
        $length = strlen($value);
        $retval = chr(0x1C) . chr($rec) . chr($data);

        if ($length < 0x8000) {
            $retval .= chr($length >> 8) . chr($length & 0xFF);
        } else {
            $retval .= chr(0x80) .
                    chr(0x04) .
                    chr(($length >> 24) & 0xFF) .
                    chr(($length >> 16) & 0xFF) .
                    chr(($length >> 8) & 0xFF) .
                    chr($length & 0xFF);
        }
        return $retval . $value;
    }

    function write($iptcData, $iptcTags, $item) {
        $video = false;
        //Pfad für Thumbs, Resize, File
        $filename = $this->file;
        $filename_resize = $item->resize_path();
        $filename_original = $item->file_path();
        
        if (!function_exists('iptcembed'))
            return false;
        $data = '';
        
        foreach ($iptcData as $key => $value) {
            $data .= $this->iptc_make_tag(2, $iptcTags[$key], $value);
        }
 
        if ($item->is_movie()) {
            //Videoformat != Thumbnailformat
            $filename = str_replace(array("flv", "avi", "mpg", "mpeg", "mov", "wmv", "asf", "mts", "mp4"), 'jpg', $filename);
            $video = true;
        }

        $content = iptcembed($data, $filename);
         
        @unlink($filename); #delete if exists
        $fp = fopen($filename, "w");
        fwrite($fp, $content);
        fclose($fp);
        
        if (!$video) {
            $content_resize = iptcembed($data, $filename_resize);
            $content_original  = iptcembed($data, $filename_original);
            
            @unlink($filename_resize); #delete if exists
            $fp_resize = fopen($filename_resize, "w");
            fwrite($fp_resize, $content_resize);
            fclose($fp_resize);

            @unlink($filename_original); #delete if exists
            $fp_original = fopen($filename_original, "w");
            fwrite($fp_original, $content_original);
            fclose($fp_original);
        }
        return $filename_original;
    }

    function get($tag) {
        return isset($this->meta["2#$tag"]) ? $this->meta["2#$tag"][0] : false;
    }
    
    function iptcTags() {
        $iptcTagsList = array(
                    'IPTC_HEADLINE' => '105',
                    'IPTC_CAPTION' => '120',
                    'IPTC_KEYWORDS' => '025',    
                    'IPTC_CITY' => '090',
                    'IPTC_COUNTRY_CODE' => '100',    
                    'IPTC_PROVINCE_STATE' => '095',       
                    'IPTC_BYLINE' => '080',   
                    'IPTC_CREDIT' => '110',
                    'IPTC_COPYRIGHT_STRING' => '116',   
                    'IPTC_OBJECT_NAME' => '005',       
                    'IPTC_CREATED_DATE' => '055',
                    'IPTC_CREATED_TIME' => '060',    
                    'IPTC_SOURCE' => '115',    
                    'IPTC_EDIT_STATUS' => '007',
                    'IPTC_PRIORITY' => '010',
                    'IPTC_CATEGORY' => '015',
                    'IPTC_SUPPLEMENTAL_CATEGORY' => '020',
                    'IPTC_FIXTURE_IDENTIFIER' => '022',
                    'IPTC_RELEASE_DATE' => '030',
                    'IPTC_RELEASE_TIME' => '035',
                    'IPTC_SPECIAL_INSTRUCTIONS' => '040',
                    'IPTC_REFERENCE_SERVICE' => '045',
                    'IPTC_REFERENCE_DATE' => '047',
                    'IPTC_REFERENCE_NUMBER' => '050',
                    'IPTC_ORIGINATING_PROGRAM' => '065',
                    'IPTC_PROGRAM_VERSION' => '070',
                    'IPTC_OBJECT_CYCLE' => '075',
                    'IPTC_BYLINE_TITLE' => '085',
                    'IPTC_COUNTRY' => '101',
                    'IPTC_ORIGINAL_TRANSMISSION_REFERENCE' => '103',
                    'IPTC_LOCAL_CAPTION' => '121'
        );
        
        foreach($iptcTagsList as $key=>$value){
            if(module::get_var("iptcedit", $key)){
                $iptcTags[$key] = $value;
            }
        }
    return $iptcTags;
    }
    
    function iptcLabels() {
        
        $iptcTags = iptcdata::iptcTags();
        
        foreach($iptcTags as $key=>$value){
            $key_label = $key."_label";
            $iptcLabels[$key] = module::get_var("iptcedit", $key_label);
        }   
    return $iptcLabels;  
    }
}
?>

