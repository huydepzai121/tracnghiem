<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Hà Quang Cường (haquangcuong210185@gmail.com)
 * @Copyright (C) 2021 haquangcuong210185 All rights reserved
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */

namespace NukeNukeViet\Module\test;

use Exception;

class import_word_to_exam
{
    public $zip;
    public $imagick;
    public $nv_Lang;
    private $file = '';
    private $array_char = array();
    // Trạng thái tiến trình xử lý gồm 2 phần: xử lý phần câu hỏi (question) và xử lý phần đáp án (answer)
    private $status_progress = 'question';
    // Trạng thái tiến trình xử lý ở mỗi câu hỏi gồm 2 phần: nội dung câu hỏi (content) và nội dung các đáp án (answer)
    private $status_question = 'content';
    // Vị trí hiện tại ở phần đáp án của mỗi câu Hỏi
    private $curent_index_answer = 0;
    public $array_question = array();
    public $array_answer = array();
    public $num_question = 0;
    public $allow_element = array('table', 'row', 'cell', 'textrun', 'text', 'listitemrun', 'image', 'section');
    public $arr_img = array();
    public $arr_width_height_img = array();
    private $index_img = 0;
    private $randon_file_name = '';
    private $array_bank_type;
    function __construct() {
        global $nv_Lang, $array_bank_type;
        $this->zip = new \ZipArchive();
        if ( extension_loaded( 'imagick' )) {
            $this->imagick = new \Imagick();
        }
        $this->lang_module = $nv_Lang;
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $this->randon_file_name = substr(str_shuffle($permitted_chars), 0, 10);
        for ($i = 65; $i < 65 + 26; $i++) {
            $this->array_char[chr($i)] = $i-64;
        }
        foreach ($array_bank_type as $value) {
            $this->array_bank_type[$value['code']] = $value['id'];
        }
        // Bổ sung
        $this->array_bank_type[1] = 1;
        $this->array_bank_type[2] = 2;
        $this->array_bank_type[3] = 3;
        $this->array_bank_type[4] = 4;
        $this->array_bank_type['nhận biết'] = 1;
        $this->array_bank_type['thông hiểu'] = 2;
        $this->array_bank_type['vận dụng'] = 3;
        $this->array_bank_type['vận dụng cao'] = 4;
        $this->array_bank_type['dễ'] = 1;
        $this->array_bank_type['vừa'] = 2;
        $this->array_bank_type['khó'] = 3;
        $this->array_bank_type['nâng cao'] = 4;

    }
     /**
     * Chuyển đổi từ đơn vị twip sang đơn vị Pixel dùng trong word
     * 96 Pixel =  1 Inch
     * 1440 twip = 1 Inch
     */
    public function convertTwiptoPixel($twip)
    {
        return  ceil($twip * ( 96/ 1440));
    }
    /**
     * Chuyển đổi từ đơn vị EMU sang đơn vị twip
     * 1 twip = 635 EMU
     */

    function convertEMUtoTwip($emu) {           
            return ceil($emu /635);                        
    }
    /**
     * Chuyển đổi từ đơn vị Pt sang đơn vị Px
     * 72Pt = 96Px
     */

    function convertPttoPx($pt) {           
            return ceil($pt * 96 / 72);                        
    }

    /**
     * Chuyển đổi từ In sang Px
     */
    function convertInchtoPx($inch) { 
        return ceil($inch * 96);
    }
    /**
     * Chuyển đổi đơn vị sang Px
     */
    function converttoPixel($type, $value) { 
        switch ($type) {
            case 'in':
                return $this->convertInchtoPx($value);
                break;
            default:
                return $this->convertPttoPx($value);
                break;
        }
    }
    /**
     * Chuyển đổi từ số thứ tự sang alphabet
     * Ví dụ 1->A, 2->B
     */
    function number_to_alphabet($number)
    {
        $number = intval($number);
        if ($number <= 0) {
            return '';
        }
        $alphabet = '';
        while ($number != 0) {
            $p = ($number - 1) % 26;
            $number = intval(($number - $p) / 26);
            $alphabet = chr(65 + $p) . $alphabet;
        }
        return $alphabet;
    }
    /**
     * Chuyển thứ tự từ câu từ dạng A, B, C sang 1, 2, 3.
     * Hiện đang tạm thời chuyển dạng chỉ có 1 ký tự dạng: A -> 1; B -> 2
     * Sau này cần thiết sẽ phát triển tiếp dạng AA = 1 * 26^1 + 1 * 26^0 = 27; ABC = 1 * 26^2 + 2 * 26^1 + 3 * 26^0 
     * Sau phát triển tiếp để chuyển từ số sang chữ thích hợp
     */
    function alphabet_to_number($c) {
        return !empty($this->array_char[$c]) ? $this->array_char[$c] : 1;
    }

    // Kiểm tra tag không có nội dung có trong $html
    function check_empty_tag($html) 
    {
        preg_match('/<([A-z0-9]+)\s*[^>\/]*>\s*<\/([A-z0-9]+)>/', $html, $mm);
        return !empty($mm) && ($mm[1]==$mm[2]) ? $mm[0] : null;
    }
    /**
     * Xóa các tag thừa, không có nội dung bên trong
     */
    function remove_tag_exuberancy($html) 
    {
        $res = $this->check_empty_tag($html);
        while (!empty($res)) {
            $html = str_replace($res, '', $html);
            $res = $this->check_empty_tag($html);
        }
        return $html;
    }
    /**
     * Xóa các từ trong $title đúng thứ tự trong html
     * $html = '<p><strong>C</strong><u><strong>â</strong></u><strong>u</strong> <strong>1</strong> <strong>.</strong>    Con gà câu 2. <strong>có mấy</strong> Cái chân</p>';
     * $title = 'Câu 1'
     * 
     */
    function remove_string_html($paragraph, $title) 
    {
        for($i = 0; $i < strlen($title); $i++) {
            $ch = substr($title, $i, 1);
            if ($ch == ' ') continue;
            $ch = ($ch == '.') ? '\.' : $ch;
            preg_match('/>[^<]*('. $ch .')[^>]*</i', $paragraph, $m, PREG_OFFSET_CAPTURE);
            preg_match('/'. $ch .'/i', $m[0][0], $m1, PREG_OFFSET_CAPTURE);
            $paragraph = substr($paragraph, 0, $m[0][1] + $m1[0][1]) . substr($paragraph,  $m[0][1] + $m1[0][1] + 1);
        }
        $paragraph = $this->remove_tag_exuberancy($paragraph);
        // Xóa khoảng trắng phía trước trong đoạn văn <p></p>
        $paragraph = preg_replace("/(^<p[^>]*>)(\s*)(.*)/", '$1$3', $paragraph);
        return $paragraph;

    }
    function praseQuestion($paragraph)
    {
        $text = strip_tags($paragraph);
        if (preg_match('/^\s*ĐÁP\s*ÁN\s*$/i', $text) || preg_match('/^\s*ANSWER\s*$/', $text)  && ($this->status_progress == 'question')) {
            $this->status_progress = 'answer';
            $paragraph = '';
        }
        else if (($this->status_progress == 'answer') && (preg_match('/^\s*<table/', $paragraph))) {
            preg_match_all('/<tr>(.*?)<\/tr>/', $paragraph, $rows);
            foreach ($rows[1] as $row) {
                preg_match_all('/<td>.*?<\/td>/', $row, $cell);
                $cell[0][0] = strip_tags($cell[0][0]);
                preg_match('/(\d+)\s*$/', $cell[0][0], $m);
                $this->num_question = $m[1] ? $m[1] : 0;
                $this->array_answer[$this->num_question] = array(
                    'type' => 0,
                    'answer' => array()
                );
                preg_match_all('/\s*<p>(.*?)<\/p>/', $cell[0][1], $aws);
                if(count($aws[1]) > 1) {
                    $this->array_answer[$this->num_question]['type'] = 2;
                    foreach ($aws[1] as $aw) {
                        $text_aw = strip_tags($aw);
                        preg_match('/^\s*([A-Z])\s*\.\s+/', $text_aw, $matches);
                        if (!empty($matches)) {
                            $this->array_answer[$this->num_question]['answer'][$matches[1]] = preg_replace('/^\s*([A-Z])\s*\.\s+/', '', $text_aw);
                        }

                    }
                } else {
                    $this->array_answer[$this->num_question]['type'] = 1;
                    $text_aw = strip_tags($cell[0][1]);
                    $arr_m = explode(',', $text_aw);
                    foreach ($arr_m as $item) {
                        $item = trim($item);
                        if (!empty($item)) {
                            $this->array_answer[$this->num_question]['answer'][$item] = true;
                        }
                    } 
                }

                if (!empty($cell[0][2])) {
                    $cell[0][2] = strip_tags($cell[0][2]);
                    $cell[0][2] = trim($cell[0][2]);
                    $cell[0][2] = mb_strtolower($cell[0][2], 'UTF-8');
                    $this->array_answer[$this->num_question]['bank_type'] = (!empty($this->array_bank_type[$cell[0][2]])) ? $this->array_bank_type[$cell[0][2]] : 1;
                }
            }
            $paragraph = '';
        }
        else if ((preg_match('/^\s*câu\s*(\d+)\s*[\.:]\s+/i', $text, $matches) || preg_match('/^\s*question\s*(\d+)\s*[\.:]\s+/i', $text, $matches))  && ($this->status_progress == 'question') && preg_match('/^<p/', $paragraph)) 
        {
            // Kiểm tra bắt đầu câu hỏi
            $paragraph = $this->remove_string_html($paragraph, $matches[0]);
            $this->num_question = intval($matches[1]);
            $this->curent_index_answer = '0';
            $this->status_question = 'content';
            $this->array_question[$this->num_question] = array(
                'content' => array(
                    0 => ''
                ),
                'answer' => array()
            );
            
        }
        else if (preg_match('/^\s*([A-Z])\s*\.\s+/', $text, $matches)  && ($this->status_progress == 'question')) {
            // Kiểm tra bắt đầu qua phần trả lời
            $this->status_question = 'answer';
            $this->array_question[$this->num_question]['answer'] = !empty($this->array_question[$this->num_question]['answer']) ? $this->array_question[$this->num_question]['answer']: array();
            if (preg_match('/^<p/', $paragraph)) {
                $arr_aw = explode("\t", $paragraph);
                foreach ($arr_aw as $aw) {
                    $aw = preg_replace('/^<p[^>]*>/', '', $aw);
                    $aw = preg_replace('/<\s*\/\s*p\s*>\s*$/', '', $aw);
                    $aw = '<p>'. $aw .'</p>';
                    $text_aw = strip_tags($aw);
                    preg_match('/^\s*([A-Z])\s*\.\s+/', $text_aw, $matches);
                    if (!empty($matches)) {
                        $this->curent_index_answer = $matches[1];
                        $aw = $this->remove_string_html($aw, $matches[0]);
                        $aw = preg_replace('/^<p[^>]*>/', '', $aw);
                        $aw = preg_replace('/<\s*\/\s*p\s*>\s*$/', '', $aw);
                        $this->array_question[$this->num_question][$this->status_question][$this->curent_index_answer] = $aw;
                    }
                }
            } else if (preg_match('/^\s*<table/', $paragraph)) {
                preg_match_all('/<td>(.*?)<\/td>/', $paragraph, $arr_aw);
                foreach ($arr_aw[1] as $aw) {
                    $text_aw = strip_tags($aw);
                    preg_match('/^\s*([A-Z])\s*\.\s+/', $text_aw, $matches);
                    if (!empty($matches)) {
                        $this->curent_index_answer = $matches[1];
                        $aw = $this->remove_string_html($aw, $matches[0]);
                        $this->array_question[$this->num_question][$this->status_question][$this->curent_index_answer] = $aw;
                    }
                }
            }
            $paragraph = '';
        }
        $this->array_question[$this->num_question][$this->status_question][$this->curent_index_answer] .= $paragraph;
    }
    function listElement($elm, $lv = 0) {
        $result = '';
        $tag_ul = is_array($elm);
        $arrays = $tag_ul ? $elm : array();
        if (!$tag_ul) {
            $class_name_path = get_class($elm);
            preg_match('/[^\\\]+$/', $class_name_path, $match);
            $class_name = trim(strtolower($match[0]));
            if (!in_array($class_name, $this->allow_element)) {
                return $result;
            }  
            $arrays = array();
            $arrays = (empty($arrays) && ($class_name == 'table')) ? $elm->getRows() : $arrays;
            $arrays = (empty($arrays) && ($class_name == 'row')) ? $elm->getCells() : $arrays;
            $arrays = (empty($arrays) && method_exists($elm,'getElements')) ? $elm->getElements() : $arrays;
        } 
        if (!empty($arrays)) {
            $tag = '';
            $tag = $tag_ul ? 'ul' : $tag;
            $tag = $class_name == 'table' ? 'table': $tag;
            $tag = $class_name == 'row' ? 'tr': $tag;
            $tag = $class_name == 'cell' ? 'td': $tag;
            $tag = $class_name == 'textrun' ? 'p': $tag;
            $tag = $class_name == 'listitemrun' ? 'li': $tag;
            $array_graph_style = array();
            if (!$tag_ul && method_exists($elm,'getParagraphStyle')) {
                $graphStyle = $elm->getParagraphStyle();
                $align = $graphStyle->getAlignment();
                if (!empty($align)) {
                    $array_graph_style[] = 'text-align: ' . $align;
                }
            }
            if (!empty($tag)) {
                $result .= '<' . $tag . (!empty($array_graph_style) ? ' style="' . implode('; ', $array_graph_style) . '"'   :'') .  '>';
            }
            $arr_li = array();
            foreach ($arrays as $e) {
                if (preg_match('/ListItemRun$/', get_class($e)) && !$tag_ul) {
                    $arr_li[] = $e;
                } else {
                    if (!empty($arr_li)) {
                        $result .= $this->listElement($arr_li, $lv + 1);
                        $arr_li = array();
                    }
                    $result .= $this->listElement($e, $lv + 1);
                }
            }
            if (!empty($arr_li)) {
                $result .= $this->listElement($arr_li, $lv + 1);
                $arr_li = array();
            }
            if (!empty($tag)) {
                $result .= '</' . $tag . '>';
            }
        } else if (method_exists($elm,'getText')) {
            $text = $elm->getText();
            if (count($text) === 0) return false;
            if (strpos($text, '{{IMAGE}}')!==FALSE) {
                $this->index_img ++;
                preg_match('/word\/media\/image(\d+)\./', $text, $m);
                $height = $this->arr_width_height_img[$this->index_img]['height'] ? $this->arr_width_height_img[$this->index_img]['height'] : 'auto';
                $width = $this->arr_width_height_img[$this->index_img]['width'] ? $this->arr_width_height_img[$this->index_img]['width'] : 'auto';
                $result .= ('<img src="'. $this->arr_img[$m[1]] .'" height="' . $height . '" width="' . $width . '"/>');
            } else {
                if (method_exists($elm,'getFontStyle') && !empty(trim($text)) && ($this->status_progress == 'question')) {
                    $styleFont = $elm->getFontStyle();
                    $style = array();
                    $size = $styleFont->getSize();
                    $color = $styleFont->getColor();
                    if (!empty($size)) {
                        $style[] = 'font-size: ' . $size . 'px';
                    }
                    if (!empty($color)) {
                        $style[] = 'color: #' . $color;
                    }
                    $text = $styleFont->isBold() ? '<strong>' . $text . '</strong>' : $text;
                    $text = $styleFont->isItalic() ? '<i>' . $text . '</i>' : $text;
                    $text = $styleFont->isSuperScript() ? '<sup>' . $text . '</sup>' : $text;
                    $text = $styleFont->isSubScript() ? '<sub>' . $text . '</sub>' : $text;
                    $text = $styleFont->isStrikethrough() ? '<s>' . $text . '</s>' : $text;
                    $text = ($styleFont->getUnderline() != 'none') ? '<u>' . $text . '</u>' : $text;
                    $text = (!empty($style)) ? '<span style="'. implode(';', $style ) .'">' . $text . '</span>' : $text;
                }
                $result .= $text;
            }

        } else if ($class_name == 'image') {
            $this->index_img ++;
            preg_match('/word\/media\/image(\d+)\./', $elm->getSource(), $m);
            $height = $this->arr_width_height_img[$this->index_img]['height'] ? $this->arr_width_height_img[$this->index_img]['height'] : 'auto';
            $width = $this->arr_width_height_img[$this->index_img]['width'] ? $this->arr_width_height_img[$this->index_img]['width'] : 'auto';
            $result .= ('<img src="'. $this->arr_img[$m[1]] .'" height="' . $height . '" width="' . $width . '"/>');
        }
        if ($lv == 1) {
            $this->praseQuestion($result);
        }
        return $result;
    }
    function exportImage() {
        $this->index_img = 0;
        $this->zip->open($this->file);
        for($i = 0; $i < $this->zip->numFiles; $i++) {
            $filename = $this->zip->getNameIndex($i);
            $fileinfo = pathinfo($filename);
            if ($fileinfo['dirname'] == 'word/media') {
                $this->index_img = intval(substr($fileinfo['filename'], 5));
                copy("zip://" . $this->file . "#" . $filename, NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' .  $this->randon_file_name . '_' . $this->index_img . '.' . $fileinfo['extension']);
                if (($fileinfo['extension'] =='wmf') && (!empty($this->imagick))) {
                    try{
                        if (stripos(php_uname(), 'window') !== FALSE ) {
                            $this->imagick->readImage(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' .  $this->randon_file_name . '_' . $this->index_img . '.' . $fileinfo['extension']);
                            $this->imagick->setImageCompression(\Imagick::COMPRESSION_JPEG);
                            $this->imagick->setImageCompressionQuality(100);
                            $this->imagick->resizeImage(500, 0,\Imagick::FILTER_LANCZOS,1);
                            $this->imagick->setImageFormat("jpg");
                            $this->imagick->stripImage();
                            $this->imagick->writeImage(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' .  $this->randon_file_name . '_' . $this->index_img . '.jpg');
                            unlink(NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' .  $this->randon_file_name . '_' . $this->index_img . '.' . $fileinfo['extension']);
                        } else {
                            $wmf_file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' .  $this->randon_file_name . '_' . $this->index_img . '.wmf';
                            $pdf_file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' .  $this->randon_file_name . '_' . $this->index_img . '.pdf';
                            $jpg_file = NV_ROOTDIR . '/' . NV_TEMP_DIR . '/' .  $this->randon_file_name . '_' . $this->index_img . '.jpg';
                            shell_exec("unoconv -f pdf -o $pdf_file $wmf_file");
                            shell_exec("convert -density 300 -trim -bordercolor white -border 5 -alpha remove $pdf_file $jpg_file");
                            unlink($wmf_file);
                            unlink($pdf_file);
                        }
                        $fileinfo['extension'] = 'jpg';

                    } catch(Exception $e) {
                        
                    }
                } 
				 $this->arr_img[$this->index_img] = NV_BASE_SITEURL . NV_TEMP_DIR . '/' . $this->randon_file_name . '_' . $this->index_img . '.' . $fileinfo['extension'];
             }
        } 
    }
    /**
     * Lấy chiều cao và chiều rộng đã được căn chỉnh cho phù hợp. 
     * Chú ý: đây không phải là chiều cao chiều rộng của ảnh mà là chiều cao, chiều rộng được căn chỉnh trong word
     */
    function get_width_hight_image( $xmlReader, $p_node, $lv=0) {
        $str_node = $p_node->tagName;
        if ($str_node == 'w:drawing') {
            $this->index_img ++;
            $cx = $xmlReader->getAttribute('cx', $p_node, 'wp:inline/wp:extent');
            $cy = $xmlReader->getAttribute('cy', $p_node, 'wp:inline/wp:extent');
            $this->arr_width_height_img[$this->index_img] = array(
                'width' => $cx ? $this->convertTwiptoPixel($this->convertEMUtoTwip($cx)) : 'auto',
                'height' => $cy ? $this->convertTwiptoPixel($this->convertEMUtoTwip($cy)) : 'auto',
            );
        } else if ($str_node == 'w:pict') {
            // Chưa biết kiểu word được lưu trữ dạng w:pict như thế nào.
            $this->index_img ++;
        } else if ($str_node == 'w:object') {
            $rid = $xmlReader->getAttribute('r:id', $p_node, 'v:shape/v:imagedata');
            if (!empty($rid)) {
                $this->index_img ++;
                $style = $xmlReader->getAttribute('style', $p_node, 'v:shape');
                preg_match('/height\s*:\s*([0-9\.]+)([^;"]*)/', $style, $m);
                $this->arr_width_height_img[$this->index_img] = array(
                    'width' => 'auto',
                    'height' => $m[1] ? $this->converttoPixel($m[2], $m[1]) : 'auto',
                );
            }
        } else {
            $nodes = $p_node->childNodes;
            foreach ($nodes as $node) {
                $this->get_width_hight_image($xmlReader, $node, $lv+1);
            }

        }
    }
    function setFile($file) { 
        $this->file = $file;
        $this->check_first_list = array();
        $this->array_question = array();
        $this->num_question = 0;
        $this->index_img = 0;
    }
    function start() {

        $this->index_img = 0;
        $xmlReader = new \PhpOffice\PhpWord\Shared\XMLReader();
        $xmlReader->getDomFromZip($this->file, 'word/document.xml');
        $nodes = $xmlReader->getElements('w:body');
        foreach ($nodes as $node) {
            $this->get_width_hight_image($xmlReader, $node);
        }
        $this->exportImage();
        
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($this->file, 'Word2007');
        $list_section = $phpWord->getSections();
        $this->index_img = 0;
        foreach ($list_section as $section) {
            $this->listElement($section);
        }
    }
    function parseQuestionForExam() {
        $parse_question = array();
        foreach ($this->array_question as $k => $pure_question) {
            if ($k == 0) continue;
            $question = array(
                'id' => 0,
                'question' => '',
                'answer' => array(),
                'useguide' => '',
                'count_true' => 0,
                'bank_type' => !empty($this->array_answer[$k]['bank_type']) ? $this->array_answer[$k]['bank_type'] : 0,
                'type' => 1,
                'error' => array(),
                'generaltext' => ''
            );
            $count_answer = count($this->array_answer[$k]['answer']);
            $question['type'] = $this->array_answer[$k]['type'] ? $this->array_answer[$k]['type'] : 1;
            $question['count_true'] = $question['type'] == 2 ? $count_answer :  $question['count_true'];
            $question['count_true'] = $question['type'] == 1 ? count($this->array_answer[$k]['answer']) :  $question['count_true'];
            $question['question'] = $pure_question['content'][0];

            $abc = array();
            foreach ($this->array_answer[$k]['answer'] as $key => $value) {
                $abc[] = $this->alphabet_to_number($key);
            }

            foreach ($pure_question['answer'] as $ch => $answer) {
                $i = $this->alphabet_to_number($ch); 
                $question['answer'][$i]['id'] =  $i;
                $question['answer'][$i]['content'] =  $answer;
                $question['answer'][$i]['is_true'] =  true;
                if ( $question['type'] == 2) {
                    $question['answer'][$i]['is_true'] = $this->array_answer[$k]['answer'][$ch];
                } else if ($question['type'] == 1) {
                    $question['answer'][$i]['is_true'] = in_array($i, array_values($abc));
                }
            }
            $parse_question[] = $question;
        }
        return array(
            'data' => $parse_question,
            'error' => 0,
        );
    }
    function getInfo() {
        return array($this->array_question, $this->array_answer);
    }
}
