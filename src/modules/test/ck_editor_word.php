<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Hà Quang Cường (haquangcuong210185@gmail.com)
 * @Copyright (C) 2021 haquangcuong210185 All rights reserved
 * @Createdate Wed, 27 Apr 2016 07:24:36 GMT
 */

namespace NukeNukeViet\Module\test;

use Exception;

/**
 * Vì trong html không có hỗ trợ tab.
 * Do đó nếu muốn xuất word có hỗ trợ tab trong paragraph thì trong tag thêm thuộc tính data-tabs = "xxx xxx xxx"
 */
class ck_editor_word
{
    /**
     * Danh sách các tag không hỗ trợ xuất ra word sẽ bị xóa
     */
    private $disable_tag_word = array('abbr','address','area','article','aside','audio','base','basefont','bdi','bdo','big','blockquote','button','canvas','center','cite','code','col','colgroup','data','datalist','dd','del','details','dfn','dialog','dir','dl','dt','embed','fieldset','figcaption','figure','font','form','frame','frameset','iframe','input','ins','kbd','label','legend','link','main','map','mark','meta','meter','nav','hr','noframes','noscript','object','optgroup','option','output','param','picture','pre','progress','q','rp','rt','ruby','samp','script','section','select','source','style','strike','summary','svg','template','textarea','time','title','track','tt','var','video','wbr');
    // xóa tag nhưng vẫn giữ nội dung bên trong
    private $container_tag = array('html','head','body', 'header','footer');
    // các tag tương ứng với các thành phần trong word
    private $allow_tag_word = array(
        'div','p','h1','h2','h3','h4','h5','h6','ul','ol','table','a', 'br'
    );
    // các tag là các thành phần bên trong các tag được phép
    private $allow_tag_word_child = array(
        'caption','thead','tbody','tfoot','tr','th', 'td','li'
    );
    private $format_tag = array(
        'sup','sub','s','i','small','strong','u', 'em','b', 'span', 'img'
    );
    private $arr_element = array();
    public $phpWord;
    public $section;
    public $objWriter;

    public $fontStyle = array(
        array(
            'size' => 13,
            'name' => 'Times New Roman',
        )
    );
    public $style_map = array(
        'font-weight' => 'bold',
        'color' => 'color',
        'font-size' => 'size',
        'background-color' => 'bgColor',
        'font-style' => 'italic',
        'font-family' => 'name',
    );
    /**
     * chuyển đổi giá trị đưa vào, nếu không có thì trả lại giá trị default
     */
    public $style_map_value = array(
        'font-weight' => array(
            'bold' => true,
            'normal' => false,
            'bolder' => true,
            'default' => false
        ),
        'color' => true, // không biến đổi
        'font-size' => true,
        'font-style' => array(
            'italic' => true,
            'normal' => false,
            'default' => false
        ),
        'font-family' => true // không biến đổi
    );

    public $paragraphStyle = array(
        array()
    );
    public $paragraph_map = array(
        'text-align' => 'alignment',
        'margin-left' => 'indent',
    );
    public $paragraph_map_value = array(
        'text-align' => array(
            'left' => 'left',
            'right' => 'right',
            'center' => 'center',
            'justify' => 'both'
        ),
        'margin-left' => true,
    );

    public $style_from_tag = array(
        'sup' => array(
            'superScript' => true
        ),
        'sub' => array(
            'subScript' => true
        ),
        's' => array(
            'strikethrough' => true
        ),
        'i' => array(
            'italic' => true
        ),
        'em' => array(
            'italic' => true
        ),
        'small' => array(
            'size' => 10
        ),
        'b' => array(
            'bold' => true
        ),
        'strong' => array(
            'bold' => true
        ),
        'u' => array(
            'underline' => 'single'
        ),
        'h1' => array(
            'size' => 18
        ),
        'h2' => array(
            'size' => 16
        ),
        'h3' => array(
            'size' => 14
        ),
        'h4' => array(
            'size' => 12
        ),
        'h5' => array(
            'size' => 10
        ),
        'h6' => array(
            'size' => 8
        ),
     
    );

    // public $tableStyle = array();

    public $table_map = array(
        'background-color' => 'bgColor',
        'border-color' => 'borderColor',
        'border-top-color' => 'borderTopColor',
        'border-bottom-color' => 'borderBottomColor',
        'border-left-color' => 'borderLeftColor',
        'border-right-color' => 'borderRightColor',
        'vertical-align' => 'valign',
    );
    public $table_map_value = array(
        'background-color' => true,
        'border-color' => true,
        'border-top-color' => true,
        'border-bottom-color' => true,
        'border-left-color' => true,
        'border-right-color' => true,
        'vertical-align' => array(
            'top' => 'top',
            'bottom' => 'bottom',
            'middle' => 'center'
        )
    );

    public $width_page;
    function __construct()
    {
        \PhpOffice\PhpWord\Settings::setDefaultPaper('A4');
        $this->phpWord = new \PhpOffice\PhpWord\PhpWord();
        $this->section = $this->phpWord->addSection(
            array(
                'marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(3),
                'marginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
                'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2),
                'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(2)
            )
        );
        $this->width_page = 6.5 * 1440;
        $this->objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->phpWord, 'Word2007');
        $this->reset();
    }
    // Chuyển đổi màu sắc từ rgb sang hex
    function fromRGB($R = 0, $G = 0, $B = 0)
    {

        $R = dechex($R);
        if (strlen($R)<2)
        $R = '0'.$R;

        $G = dechex($G);
        if (strlen($G)<2)
        $G = '0'.$G;

        $B = dechex($B);
        if (strlen($B)<2)
        $B = '0'.$B;

        return '#' . $R . $G . $B;
    }
    /**
     * Chuyển đổi từ đơn vị Pixel sang đơn vị twip dùng trong word
     * 96 Pixel =  1 Inch
     * 1440 twip = 1 Inch
     */
    public function convertPixeltoTwip($px)
    {
        return  ceil($px * (1440 / 96));
    }
    public function reset()
    {
        $this->arr_element = array();
        $this->fontStyle = array(
            array(
                'size' => 13,
                'name' => 'Times New Roman',
            )
        );
        $this->paragraphStyle = array(
            array(
                'tabs' => array(
                    new \PhpOffice\PhpWord\Style\Tab('left', intval($this->width_page / 4) * 1),
                    new \PhpOffice\PhpWord\Style\Tab('left', intval($this->width_page / 4) * 2),
                    new \PhpOffice\PhpWord\Style\Tab('left', intval($this->width_page / 4) * 3),
                )
            )
        );
        $this->tableStyle = array();
    }
    public function addHeader($content, $style = null, $paragraphStyle = null) {
        $header = $this->section->addHeader();
        $header->addText($content, $style, $paragraphStyle);
    }
    public function addEditor($ck_editor_html)
    {
        $ck_editor_html = str_replace(array("\n", "\r"), '', $ck_editor_html);
        $ck_editor_html = str_replace("'", "\"", $ck_editor_html);
        // Loại bỏ các tag không sử dụng trong word
        
        foreach ($this->disable_tag_word as $tag) {
            // Loại bỏ các tab có close tag
            $arr_tag = $this->getListTag($tag, $ck_editor_html);
            foreach ($arr_tag as $rm) {
                $ck_editor_html = str_replace($rm, '', $ck_editor_html);
            }

            // Loại bỏ các tag không có close tag
            $pattern = '/<\s*'. $tag .'\s*[^>]*>/';
            $ck_editor_html = preg_replace($pattern, '', $ck_editor_html);
        }
        
        foreach ($this->container_tag as $tag) {
            $pattern = '/<\s*'. $tag .'\s*[^>]*>/';
            $ck_editor_html = preg_replace($pattern, '', $ck_editor_html);
            $pattern = '/<\s*\/\s*'. $tag .'\s*[^>]*>/';
            $ck_editor_html = preg_replace($pattern, '', $ck_editor_html);
        }

        $all_tag = array();

        foreach ($this->allow_tag_word as $tag) {
            $pattern = '/<\s*' . $tag . '\s*[^<]*>/';
            preg_match_all($pattern, $ck_editor_html, $f_matches, PREG_OFFSET_CAPTURE);
            $all_tag = array_merge($all_tag, $f_matches[0]);

            $pattern = '/<\s*\/\s*' . $tag . '\s*>/';
            preg_match_all($pattern, $ck_editor_html, $l_matches, PREG_OFFSET_CAPTURE);
            $all_tag = array_merge($all_tag, $l_matches[0]);
        }
        uasort($all_tag, function ($a, $b) {
            return $a[1] < $b[1] ? -1: 1;
        });
        $all_tag = array_values($all_tag);
        $pre_index = 0;
        // $level được sử dụng cho div.
        $level = 0;
        // $lv được sử dụng cho các tag khác để có thể lấy được toàn bộ nội dung tag.
        $lv = 0;
        foreach ($all_tag as $item) {
            $level_add = 0;
            $type = 'text';
            preg_match('/div/', $item[0], $m);
            $is_div =  !empty($m);

            preg_match('/<\s*\/*br[^>]*>/', $item[0], $m);
            $is_br =  !empty($m);

            preg_match('/<\s*\/[A-z0-9]+\s*>/', $item[0], $m);
            $is_close_tag = !empty($m);
            
            // Vì <br/> là 1 tag đặc biệt không có tag đóng mở riêng nên nếu gặp thì xem nó là tag mở
            // Sau đó thì đóng nó lại
            $lv += (($is_div) ? 0 : (($is_br || !$is_close_tag) ? 1 : -1));
            if (($lv > 1)) {
                $lv += ($is_br ? -1 : 0);
                continue;
            }

            $content = trim(substr($ck_editor_html, $pre_index, $item[1] - $pre_index));
            $pre_index = $item[1];
            
            $pre_index += ($is_div || $is_close_tag) ? strlen($item[0]) : 0 ;
            $content .= (!$is_div && $is_close_tag) ? $item[0] : '';
            $level_add = !$is_div ? 0 : (!$is_close_tag ? 1 : -1);

            if (!$is_div && $is_close_tag) {
                preg_match('/<\s*\/([A-z0-9]+)\s*>/', $item[0], $m);
                $type = $m[1];
            }

            if (!empty($content)) {
                $this->arr_element[] = array(
                        'type' => $type,
                        'content' => $content,
                        'level' => $level
                );
            }

            if ($is_div && !$is_close_tag) {
                $this->arr_element[] = array(
                    'type' => 'div',
                    'content' => $item[0],
                    'level' => $level
                );
            }

            if ($is_br) {
                $this->arr_element[] = array(
                    'type' => 'br',
                    'content' => $content,
                    'level' => $level
                );
                $pre_index += strlen($item[0]);
            }
            
            $level += $level_add;
        }
        // Lấy nội dung cuối cùng không ở trong bất kỳ tag nào
        if ($pre_index < strlen($ck_editor_html)) {
            $content = trim(substr($ck_editor_html, $pre_index, strlen($ck_editor_html) - $pre_index));
            if (!empty($content)) {
                $this->arr_element[] = array(
                        'type' =>'text',
                        'content' => $content,
                        'level' => $level
                );
            }
        }
    }
    public function getElements()
    {
        return $this->arr_element;
    }
    /**
     * Chuyển đổi các định dạng style tương ứng thành các định dạng của word
     * Ví dụ chuyển từ style= "font-style:italic" thành array('italic' => true)
     * @param style có dạng như font-style:italic
     */
    public function convert_css_to_style($style)
    {
        $arr_result = array();
        $arr_style = explode(':', $style);
        $type = trim($arr_style[0]);
        $value = trim($arr_style[1]);
        if (!empty($type) && !empty($value) && !empty($this->style_map[$type])) {
            $key = $this->style_map[$type];
            if ($type == 'font-size') {
                $value = preg_replace('/px/', '', $value);
            } elseif ($this->style_map_value[$type] !== true) {
                $value = isset($this->style_map_value[$type][$value]) ?
                $this->style_map_value[$type][$value] : $this->style_map_value[$type]['default'];
            } 
            $arr_result[$key] = $value;
        }
        return $arr_result;
    }
    /**
     * Lấy các style của word từ style của tag
     * @param open_tag có dạng <span style="color: #ff0; font-size: 18px; font-weight: bold;">
     * @return resutl có dạng array
     * 'xxxx'=>'yyyy',
     * 'xxxx'=>'yyyy',
     * 'xxxx'=>'yyyy',
     */
    public function getStyle($open_tag)
    {
        // Lấy định dạng dựa vào tag ví dụ như: <u> gạch chân</u>; <i>in nghiên</i>
        $pattern = '/^<\s*([A-z0-9]*)\s*/';
        preg_match($pattern, $open_tag, $matches);
        $arr_result = isset($this->style_from_tag[$matches[1]]) ? $this->style_from_tag[$matches[1]] : array();

        // Lấy định dạng dựa vào style
        $pattern = '/^<\s*[A-z0-9]+\s*[^>]*\s*style\s*=\s*["\']([^"\']*)["\']/';
        preg_match($pattern, $open_tag, $matches);
        $arr_css = explode(';', $matches[1]);
        foreach ($arr_css as $style) {
            $convert = $this->convert_css_to_style($style);
            $arr_result = !empty($convert) ? array_merge($arr_result, $convert) : $arr_result;
        }

        return $arr_result;
    }



    public function convert_css_to_paragraphStyle($style)
    {
        $arr_result = array();
        $arr_style = explode(':', $style);
        $type = trim($arr_style[0]);
        $value = trim($arr_style[1]);
        if (!empty($type) && !empty($value) && !empty($this->paragraph_map[$type])) {
            $key = $this->paragraph_map[$type];
            if ($type == 'margin-left') {
                preg_match('/[0-9]+/', $value, $m);
                $value = $this->convertPixeltoTwip($m[0]);
            } elseif ($this->paragraph_map_value[$type] !== true) {
                $value = isset($this->paragraph_map_value[$type][$value]) ?
                $this->paragraph_map_value[$type][$value] : $this->paragraph_map_value[$type]['default'];
            }
            $arr_result[$key] = $value;
        }
        return $arr_result;
    }
    public function getParagraphStyle($open_tag)
    {
        $arr_result = array();
        $pattern = '/style\s*=\s*["\']([^"\']*)["\']/';
        preg_match($pattern, $open_tag, $matches);
        $arr_css = explode(';', $matches[1]);
        foreach ($arr_css as $style) {
            $convert = $this->convert_css_to_paragraphStyle($style);
            $arr_result = !empty($convert) ? array_merge($arr_result, $convert) : $arr_result;
        }
        // Lấy định dạng dựa vào class
        // Hiện tại ở phần này chỉ lấy class="image-center" để căn giữa cho bức ảnh ở giữa div.
        $map_class = array(
            'image-center' => array(
                'alignment' => 'center'
            )
        );
        $pattern = '/^<\s*[A-z0-9]+\s*[^>]*\s*class\s*=\s*["\']([^"\']*)["\']/';
        preg_match($pattern, $open_tag, $matches);
        $pattern = '/[^\s]+/';
        preg_match_all($pattern, $matches[1], $m);
        foreach ($m[0] as $cl) {
            $arr_result = !empty($map_class[$cl]) ? array_merge($arr_result, $map_class[$cl]) : $arr_result;
        }
        // Lấy tabs
        // Cái này do mình tự định nghĩa không có trong mặc định của html dùng để cấu hình tabs khi xuất word
        preg_match('/^<\s*[A-z0-9]+\s*[^>]*\s*data-tabs\s*=\s*"([^"]*)"/', $open_tag, $matches);
        preg_match_all('/[0-9]+/', $matches[1], $m);
        $arr_tab = array();
        foreach ($m[0] as $tab) {
            $arr_tab[] = new \PhpOffice\PhpWord\Style\Tab('left', $tab);
        }
        $arr_result = !empty($arr_tab) ? array_merge($arr_result, array(
            'tabs' => $arr_tab
        )) : $arr_result;
        return $arr_result;
    }
    public function convert_css_to_tableStyle($style)
    {

        $arr_result = array();
        $arr_style = explode(':', $style);
        $type = trim($arr_style[0]);
        $value = trim($arr_style[1]);

        if (!empty($type) && !empty($value) && !empty($this->table_map[$type])) {
            $key = $this->table_map[$type];
            if ($this->table_map_value[$type] !== true) {
                $value = isset($this->table_map_value[$type][$value]) ?
                $this->table_map_value[$type][$value] : $this->table_map_value[$type]['default'];
            } 
            else if ((strpos($type, 'color') !== false) && (strpos($value, 'rgb') !== false)) {
                $pattern = '/([0-9]+)\s*,\s*([0-9]+)\s*,\s*([0-9]+)/';
                preg_match_all($pattern, $value, $matches);
                $value = $this->fromRGB($matches[1][0], $matches[2][0], $matches[3][0]);
            } 
            $arr_result[$key] = $value;
        }  
        return $arr_result;
    }
  
    public function getTableStyle($open_tag)
    {
        
        $arr_result = array();
        // Lấy định dạng dựa vào style
        $pattern = '/^<\s*table\s*[^>]*\s*style\s*=\s*"([^"\']*)"/';
        preg_match($pattern, $open_tag, $matches);
        $arr_css = explode(';', $matches[1]);
        foreach ($arr_css as $style) {
            $convert = $this->convert_css_to_tableStyle($style);
            $arr_result = !empty($convert) ? array_merge($arr_result, $convert) : $arr_result;
        }
        return $arr_result;
    }

    public function clearContent($content)
    {
        // Xóa các tag chẳng may vì một lý do gì đó còn sót lại trong content ảnh hưởng đến việc xuất word
        foreach (array_merge($this->allow_tag_word_child, $this->allow_tag_word) as $tag) {
            if ($tag == 'br') continue;
            $pattern = '/<\s*'. $tag .'\s*[^>]*>/';
            $content = preg_replace($pattern, '', $content);
            $pattern = '/<\s*\/\s*'. $tag .'\s*[^>]*>/';
            $content = preg_replace($pattern, '', $content);
        }
        $content = str_replace(array('&lt;', '&gt;', '&amp;', '&quot;'), array('_lt_', '_gt_', '_amp_', '_quot_'), $content);
        $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
        $content = str_replace('&', '&amp;', $content);
        $content = str_replace(array('_lt_', '_gt_', '_amp_', '_quot_'), array('&lt;', '&gt;', '&amp;', '&quot;'), $content);
        return $content;
    }

    /**
     * Xữ lý content để đưa vào textrun
     * content có thể có dạng: xxxx xxxx xxxx<u>xxx xxx</u><span sytle="xxxx">yyy</span>zzzzzz
     * Đã loại bỏ các tag p , h1, h2, h3, h4, h5, h6 ... ở trước và sau
     */
    public function addText($content, $textrun = null)
    {
        if ($textrun === null) {
            $paragraphStyle = array();
            foreach ($this->paragraphStyle as $style) {
                $paragraphStyle = array_merge($paragraphStyle, $style);
            }
            $textrun = $this->section->addTextRun($paragraphStyle);
        }

        $fontStyle = array();
        foreach ($this->fontStyle as $style) {
            $fontStyle = array_merge($fontStyle, $style);
        }
        $content = $this->clearContent($content);
        $content = '<span>'. $content . '</span>';
        $add_fontStyle = array();
        $pattern = '/<[^<>]*>/';
        preg_match_all($pattern, $content, $matches, PREG_OFFSET_CAPTURE);
        $pre_index = 0;
        foreach ($matches[0] as $item) {
            preg_match('/<\s*[A-z0-9]+\s*[^>]*>/', $item[0], $m);
            $is_open_tag = !empty($m);
            preg_match('/<\s*\/*\s*([A-z0-9]+)\s*[^>]*>/', $item[0], $m);
            $tag = $m[1];

            $text = substr($content, $pre_index, $item[1] - $pre_index);
            $pre_index = $item[1] + strlen($item[0]);

            $element_style = array_merge(array(), $fontStyle);
            foreach ($add_fontStyle as $style) {
                $element_style = array_merge($element_style, $style);
            }
            if (!empty($text)) {
               /*  $arr_split = preg_split('/\\\t/', $text);
                $text = "";
                $last_text = array_pop($arr_split);
                foreach ($arr_split as $arr) {
                    $text .= $arr . "\t";
                }
                $text .= $last_text; */
                $textrun->addText($text, $element_style);
            }
            if ($is_open_tag) {
                $add_fontStyle[] = in_array($tag, array_keys($this->style_from_tag)) ? $this->style_from_tag[$tag] :
                (($tag == 'span') ? $this->getStyle($item[0]) : array());
            } else {
                array_pop($add_fontStyle);
            }
            if ($tag == 'img') {
                $this->addImg($item[0], $textrun);
            } else if ($tag == 'br') {
                $textrun->addTextBreak();
            }
        }
    }
    /**
     * Lấy danh sách các tag theo thứ tự trong content được đưa vào.
     * $postion = true sẽ trả về vị trí của tag đó phục vụ cho việc lấy nhiều tag khác nhau và để sắp xếp các tag đó đúng thứ tự
     */
    public function getListTag($tag, $content, $position = false)
    {
        $arr_result = array();
        $all_tag = array();
        $pattern = '/<\s*' . $tag . '\s*[^<]*>/';
        preg_match_all($pattern, $content, $f_matches, PREG_OFFSET_CAPTURE);
        $all_tag = array_merge($all_tag, $f_matches[0]);

        $pattern = '/<\s*\/\s*' . $tag . '\s*>/';
        preg_match_all($pattern, $content, $l_matches, PREG_OFFSET_CAPTURE);
        $all_tag = array_merge($all_tag, $l_matches[0]);
        if (empty($all_tag)) {
            return array();
        }
        uasort($all_tag, function ($a, $b) {
            return $a[1] < $b[1] ? -1: 1;
        });
        $all_tag = array_values($all_tag);
        $pre_index = 0;
        $lv = 0;
        for ($i = 0; $i < count($all_tag); $i++) {
            preg_match('/<\s*\/[A-z0-9]+\s*>/', $all_tag[$i][0], $m);
            $is_close_tag = !empty($m);

            $lv += $is_close_tag ? -1 : 1;
            if (($lv > 0) && !($lv == 1 && !$is_close_tag)) {
                continue;
            }
            if ($is_close_tag) {
                $value = trim(substr($content, $pre_index, $all_tag[$i][1] + strlen($all_tag[$i][0]) - $pre_index));
                if ($position) {
                    $arr_result[] = array($value, $pre_index);
                } else {
                    $arr_result[] = $value;
                }
            }
            $pre_index = !$is_close_tag ? $all_tag[$i][1] : $all_tag[$i][1] + strlen($all_tag[$i][0]);
        }
        return $arr_result;
    }
    /**
     * Lấy dữ liệu trong table trả về theo nhóm của từng hàng.
     * dạng Array (
     * [0] => Array
     * (
     *         [0] => <th scope="row">a</th>
     *         [1] => <th scope="col">b</th>
     *     )
     *
     * [1] => Array
     *     (
     *      [0] => <th scope="row">1</th>
     *      [1] => <td>a</td>
     *     )
     */
    public function getDataFromTable($content)
    {
        $data = array();
        $arr_tr = $this->getListTag('tr', $content);
        foreach ($arr_tr as $tr) {
            $arr_th = $this->getListTag('th', $tr, true);
            $arr_td = $this->getListTag('td', $tr, true);
            $all_tag = array_merge($arr_th, $arr_td);
            uasort($all_tag, function ($a, $b) {
                return $a[1] < $b[1] ? -1: 1;
            });
            $all_tag = array_values($all_tag);
            $data[] = array_map(function ($tag) {
                return $tag[0];
            }, $all_tag);
        }
        return $data;
    }
    public function addTable($content)
    {
        $data = $this->getDataFromTable($content);
        if (empty($data)) {
            return false;
        }
        
        preg_match('/<\s*table\s*[^<]*style\s*=\s*"([^<"]*)"/', $content, $matches);
        $width_table_style = $matches[1];

        preg_match('/width\s*:\s*([0-9]*)/', $width_table_style, $matches);
        $width_table = $this->convertPixeltoTwip($matches[1]);
        $width_table = !empty($width_table) ? $width_table : $this->width_page;
        $num_column = count($data[0]);
        $width_column = floor($width_table / $num_column);

        preg_match('/<\s*table\s*[^<]*align\s*=\s*"([^<"]*)"/', $content, $matches);
        $align_table = $matches[1] ? $matches[1] : 'left';
        
        preg_match('/<\s*table\s*[^<]*tblHeader\s*=\s*"([^<"]*)"/', $content, $matches);
        $tblHeader = $matches[1] && (($matches[1] === 'true') || ($matches[1] === true)) ? true : false;

        preg_match('/thead/', $content, $matches);
        $is_thead = !empty($matches);

        preg_match_all('/<\s*tbody/', $content, $m);
        $is_thead = $is_thead || (count($m[0]) > 1);

        preg_match('/<\s*caption\s*>(.*)<\s*\/\s*caption\s*>/', $content, $matches);
        
        $caption = $matches[1];
        if (strlen($caption)) {
            $header = array('size' => 16, 'bold' => true );
            $this->section->addText($caption, $header, array('alignment' => 'center'));
        }

        // $styleFirstRow = $is_thead ? array('bgColor' => 'A6A6A6') : array();

        $styleTable = $this->getTableStyle($content);
        $styleTable = array_merge(array(
            'borderSize' => 10,
            'borderColor' => '0D0D0D',
            'cellMargin' => 100,
            'align' => $align_table
        ), $styleTable);
        
        $styleCell = array('valign' => $styleTable['valign'] ? $styleTable['valign'] : 'center');

        $table = $this->section->addTable($styleTable);
        for ($i = 0; $i < count($data); $i++) {
            $table->addRow(($is_thead && ($i == 0)) ? 500 : null, $tblHeader && ($i == 0) ? array('tblHeader' => true) : array());
            foreach ($data[$i] as $cell) {
                preg_match('/<\s*th\s*[^>]*>/', $cell, $m);
                $is_th = !empty($m);

                $this->paragraphStyle[]  = $this->getParagraphStyle($cell);
                $paragraphStyle = array();
                foreach ($this->paragraphStyle as $style) {
                    $paragraphStyle = array_merge($paragraphStyle, $style);
                }
                $paragraphStyle =  array_merge($paragraphStyle, array('spaceAfter' => 0));
                if ($is_thead && ($i == 0)) {
                    $this->fontStyle[]  = array_merge($this->getStyle($cell), array('bold' => true));
                    $paragraphStyle =  array_merge($paragraphStyle, array('alignment' => 'center'));
                } else {
                    $this->fontStyle[]  = array_merge($this->getStyle($cell), $is_th ? array(
                        'bold' => true,
                    ) : array());
                }

                preg_match('/<\s*[tdh]+\s*[^<]*style\s*=\s*"([^<"]*)"/', $cell, $matches);
                $width_cell_style = $matches[1];
                preg_match('/width\s*:\s*([0-9]*)/', $width_cell_style, $matches);
                $width_cell = $this->convertPixeltoTwip($matches[1]);
                $width_cell = !empty($width_cell) ? $width_cell : $width_column;

                $cell = preg_replace('/<\s*th\s*[^<]*>/', '', $cell);
                $cell = preg_replace('/<\s*td\s*[^<]*>/', '', $cell);
                $cell = preg_replace('/<\s*\/\s*th\s*[^<]*>/', '', $cell);
                $cell = preg_replace('/<\s*\/\s*td\s*[^<]*>/', '', $cell);
                // Xóa tab ở nội dung của table: Trong ckeditor nó hay tự động sinh tab làm ảnh hưởng đến định dạng của word
                $cell = preg_replace('/\\\t/', '', $cell);
                $cell = preg_replace('/\t/', '', $cell);

                preg_match('/^[0-9,\.]+$/', $cell, $m);
                $is_number = !empty($m);
                $paragraphStyle =  array_merge($paragraphStyle, $is_number ? array('alignment' => 'right') : array());

                $textrun = $table->addCell($width_cell, $styleCell)->addTextRun($paragraphStyle);
                $this->addText($cell, $textrun);
                array_pop($this->fontStyle);
                array_pop($this->paragraphStyle);
            }
        }
    }
    public function addList($content, $tag = 'ul', $depth = 0)
    {
        $arr_li = $this->getListTag('li', $content);
        $predefinedMultilevel = $tag == 'ol' ?
            array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_NUMBER_NESTED) :
            array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED);
        foreach ($arr_li as $li) {
            $listItemRun = $this->section->addListItemRun($depth, $predefinedMultilevel, array('indent' => ($depth + 1) ));
            $pattern = '/<\s*ul\s*[^>]*>/';
            preg_match($pattern, $li, $m_ul, PREG_OFFSET_CAPTURE);
            $pattern = '/<\s*ol\s*[^>]*>/';
            preg_match($pattern, $li, $m_ol, PREG_OFFSET_CAPTURE);
            $this->fontStyle[]  = $this->getStyle($li);
            $this->paragraphStyle[] = $this->getParagraphStyle($li);
            if (!empty($m_ul) || !empty($m_ol)) {
                $i_u = !empty($m_ul[0][1]) ? $m_ul[0][1] : null;
                $i_o = !empty($m_ol[0][1]) ? $m_ol[0][1] : null;
                $tag = ( !empty($m_ul) && !empty($m_ol) ) ? ( $i_u < $i_o ? 'ul' : 'ol' ) :
                (!empty($m_ul) ? 'ul' : 'ol'  );

                preg_match('/<\s*li\s*[^>]*>/', $li, $matches);
                $f_index = strlen($matches[0]);
                preg_match('/<\s*'. $tag. '\s*[^>]*>/', $li, $matches, PREG_OFFSET_CAPTURE);
                $l_index = $matches[0][1];
                $text = trim(substr($li, $f_index, $l_index - $f_index));
                $this->addText($text, $listItemRun);

                $ul_ol_tag = $this->getListTag($tag, $li);
                $this->addList($ul_ol_tag[0], $tag, $depth + 1);
            } else {
                $pattern = '/<\s*li\s*[^<]*>(.*)<\s*\/\s*li\s*>/';
                preg_match($pattern, $li, $matches);
                $this->addText($matches[1], $listItemRun);
            }
            array_pop($this->fontStyle);
            array_pop($this->paragraphStyle);
        }
    }
    public function addImg($content, $textrun)
    {

        $pattern = '/<\s*img\s*[^>]*height\s*=\s*"\s*([0-9]+)\s*/';
        preg_match($pattern, $content, $matches);
        $height = !empty($matches[1]) ? $matches[1] : 100;

        $pattern = '/<\s*img\s*[^>]*style\s*=\s*"[^"]*height\s*:\s*([0-9]+)/';
        preg_match($pattern, $content, $matches);
        $height = !empty($matches) ? $matches[1] : $height;

        $pattern = '/<\s*img\s*[^>]*width\s*=\s*"\s*([0-9]+)\s*/';
        preg_match($pattern, $content, $matches);
        $width = !empty($matches[1]) ? $matches[1] : 100;

        $pattern = '/<\s*img\s*[^>]*style\s*=\s*"[^"]*width\s*:\s*([0-9]+)/';
        preg_match($pattern, $content, $matches);
        $width = !empty($matches) ? $matches[1] : $width;

        $map_class = array(
            'image-right' => array(
                'wrappingStyle' => 'square',
                'positioning' => 'absolute',
                'posHorizontal'    => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
                'posHorizontalRel' => 'margin',
                'posVerticalRel' => 'line',
            ),
            'image-left' => array(
                'wrappingStyle' => 'square',
                'positioning' => 'absolute',
                'posHorizontal'    => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_LEFT,
                'posHorizontalRel' => 'margin',
                'posVerticalRel' => 'line',
            )
        );

        $pattern = '/^<\s*[A-z0-9]+\s*[^>]*\s*class\s*=\s*["\']([^"\']*)["\']/';
        preg_match($pattern, $content, $matches);
        $pattern = '/[^\s]+/';
        preg_match_all($pattern, $matches[1], $m);
        $arr_result = array(
            'height' => $height * 72 / 96,
            'width' =>  $width * 72 / 96
        );
        foreach ($m[0] as $cl) {
            $arr_result = !empty($map_class[$cl]) ? array_merge($arr_result, $map_class[$cl]) : $arr_result;
        }
        $pattern = '/<\s*img\s*[^>]*src\s*=\s*"\s*([^"]+)\s*/';
        preg_match($pattern, $content, $matches);
        $src = $matches[1];
        try {
            $source = file_get_contents(NV_ROOTDIR . $src);
            $textrun->addImage($source, $arr_result);
        } catch (Exception $e) {
        }
    }
    /**
     * @param element: array (
     *      type => div | text | p | h1 ...h6 | table | ul ...
     *      content => nội dung có thể dạng <p class="color: #ff0">cường <u>vit con</u><span class="bbbb"><u>con ngựa chạy</u></span></p>
     *      level => căn cứ để có thể thêm hoặc bớt style.
     * )
     * type = div: thì chỉ lấy định dạng có ở content để áp dụng cho những thành phần con được đưa vào sau.
     * định dạng có trong class của thành phần.
     * Nếu type = 'text' thì không lấy định dạng.
     */
    public function addElement($element)
    {
        // Loại bỏ các định dạng chung cấp thấp hơn
        while (count($this->fontStyle) > ($element['level'] + 1)) {
            array_pop($this->fontStyle);
        }
        while (count($this->paragraphStyle) > ($element['level'] + 1)) {
            array_pop($this->paragraphStyle);
        }
        // Lấy định dạng.
        $this->fontStyle[]  = ($element['type'] !== 'text') ? $this->getStyle($element['content']) : array();
        $this->paragraphStyle[] = ($element['type'] !== 'text') ? $this->getParagraphStyle($element['content']) : array();
        
        if ($element['type'] !== 'div') {
            // Lấy nội dung
            $content = $element['content'];
            if (!in_array($element['type'], array('text', 'table', 'ul', 'ol'))) {
                $pattern = '/<\s*' . $element['type'] . '\s*[^<]*>(.*)<\s*\/\s*' . $element['type'] .'\s*>/';
                preg_match($pattern, $content, $matches);
                $content = $matches[1];
            }
            
            if ($element['type'] == 'table') {
                $this->addTable($content);
            } elseif (($element['type'] == 'ul') || ($element['type'] == 'ol')) {
                $this->addList($content, $element['type']);
            } elseif ($element['type'] == 'br') {
                $this->section->addTextBreak();
            } elseif ($element['type'] == 'pageBreak') {
                $this->section->addPageBreak();
            } else {
                $this->addText($content);
            }
        }
    }
    public function addPageBreak()
    {
        $this->arr_element[] = array(
            'type' => 'pageBreak'
        );
    }
    public function addTextBreak($num_line = 1)
    {
        for ($i = 0; $i < $num_line; $i++) {
            $this->addEditor('<br />');
        }
    }
    /**
     * Chèn nội dung vào html Ví dụ
     * @param string $content = '<span class="font-weight: bold; color: #000000">Câu 1.</span>'
     * @param string $html = '<p style="background-color: #ff0000">Con bò có mấy chân</p>';
     * @return string $html = '<p style="background-color: #ff0000"><span class="font-weight: bold; color: #000000">Câu 1.</span>Con bò có mấy chân</p>'
     */
    public function insert_content_into_html($content, $html)
    {
        $pattern = '/(^<\s*[A-z0-9]+[^>]*>)(.*)/';
        preg_match($pattern, trim($html), $matches);
        if (!empty($matches)) {
            $html = trim($html);
            $html = preg_replace($pattern, '${1}'. $content . '${2}', $html);
        } else {
            $html = $content . $html;
        }
        return $html;
    }
    public function export_word($filename, $path = '/')
    {
        $elements = $this->getElements();
        foreach ($elements as $element) {
            $this->addElement($element);
        }
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $filename . '.docx"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $this->objWriter->save("php://output");
        // $this->objWriter->save(NV_ROOTDIR . '/helloWorld.docx');
        exit();
    }
}

/**
 $ck_editor_html = '
    con gà nhỏ bé ở trong vườn
    zzz<p>abc
    </p>
    <div style="text-align:center">
        một con vịt xòe ra hai cái cánh
        <p style="color: #ff0">cường <u>vit con</u><span class="bbbb"><u>con ngựa chạy</u></span></p>
        <div>a1</div>
        <div>a2</div>
        một hàng ở giữa div
        <div style="text-align: right">
            cô giáo lớp em
            <div>
                <p>hôm qua em đi chùa hương</p>
                <p>sáng nào em đến lớp</p>
            </div>
            <p>cũng thấy cô đến rồi</p>
            <div>
                <h1>đáp lời chào cô ạ</h1>
                cô mĩn cười thật tươi
                <p>bao chau 2</p>
                <h1>chuc nang h1 thu 2</h1>
            </div>
            <h1>chuc nang h1<u>vit con</u><span style="color:#FF0000"><u>gggg</u></span> thu 3</h1>
        </div>
        một hàng <u>ở cuối</u> cùng của div
    </div>
    <p>cô dạy em tập viết</p>
    <div>
        gió đưa thoảng hương nhài
        <p>nắng ghé vào cửa lớp</p>
        <div style="color:FF0000">
            xem chúng em học bài
            <div>yêu thương em ngắm mãi</div>
            <table align="right" border="1" cellpadding="1" cellspacing="1" style="width:500px; height: 700px" class="abc">
<caption>Danh sách học sinh</caption>
<thead>
    <tr>
        <th scope="row"><u>con </u><b>ga </b>a</th>
        <th scope="col">b</th>
        <th scope="col">c</th>
        <th scope="col">d</th>
        <td scope="col">e</td>
        <th scope="col">f</th>
    </tr>
</thead>
<tbody>
    <tr style="text-align:center">
        <th scope="row">1</th>
        <td>a</td>
        <td><u><em><strong>d</strong></em></u></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th scope="row">2</th>
        <td>b</td>
        <td><u>f</u></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th scope="row">3</th>
        <td>c</td>
        <td><span style="text-align: center">e<sub>2</sub>+e<sup>3</sup></span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <th scope="row">4</th>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</tbody>
</table>
        </div>
    </div>
    <p>hang cuoi cung</p>
    thêm một hàng <strong>text ở cuối cùng</strong>
';
$ck_editor_html = '
Con ga nho bé
<span style="">Khi làm việc với Word xong, muốn thoát khỏi, ta thực hiện</span>
<div class="image-center agc gee   bbb cc">
    Anh o day nhe <img alt="4" height="133" src="/uploads/testtrungtam/test/2021/4.jpg" width="100"/> thong thuong
    <h1>Chinh anh ben trai</h1>
    <img alt="4" height="133" src="/uploads/testtrungtam/test/2021/4.jpg" width="100" class="image-left"/>
    <h1>Chinh anh ben phai</h1>
    <img alt="4" height="133" src="/uploads/testtrungtam/test/2021/4.jpg" width="100" class="image-right"/>
    <h1>Chinh anh ơ giua</h1>
    <div class="image-center>
    <img alt="4" height="133" src="/uploads/testtrungtam/test/2021/4.jpg" width="100"/>

    </div>
    <u>ket thuc</u>
    <p>hang khac</p>
    </div>
&nbsp;
<p>Một con vịt xòe ra 2 cái cánh</p>
<ul>
    <li style="color:#0000ff">
        <span style="color:#ff0000">a</span>
        <ol>
            <li>mmm1</li>
            <li>mmm2</li>
            <li>mmm3
                <ul>
                    <li>mot</li>
                    <li>hai</li>
                    <li>ba</li>
                </ul>
            </li>
        </ol>
    </li>
    <li><span style="font-weight: bold">b</span></li>
    <li><span style="font-weight: bold">c</span></li>
</ul>
<h1>ggg <p>con ga nho</p>bbb</h1>
';
 */
