<?php
/**
 * 安全
 * @version 1.0
 * xss ,sql注入
 */
class lib_security
{
	const XSS_CLEAN_ALL_HTML_TAGS = 'ALL_HTML_TAGS'; // 过滤所有的 html tag
	const XSS_CLEAN_NOLY_SCRIPT_TAGS = 'NOLY_SCRIPT_TAGS'; // 只过滤脚本
	const XSS_CLEAN_NO_DENY = "NO_DENY";

	public function xss_clean($val) {
		$val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
	   	$search = 'abcdefghijklmnopqrstuvwxyz';
	   	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	   	$search .= '1234567890!@#$%^&*()';
	   	$search .= '~`";:?+/={}[]-_|\'\\';
	   	for ($i = 0; $i < strlen($search); $i++) {
	      	$val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
	      	$val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
	   	}

	   	$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	   	$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	   	$ra = array_merge($ra1, $ra2);

	   	$found = true;
	   	while ($found == true) {
	      	$val_before = $val;
	      	for ($i = 0; $i < sizeof($ra); $i++) {
	         	$pattern = '/';
	         	for ($j = 0; $j < strlen($ra[$i]); $j++) {
	            	if ($j > 0) {
		               $pattern .= '(';
		               $pattern .= '(&#[xX]0{0,8}([9ab]);)';
		               $pattern .= '|';
		               $pattern .= '|(&#0{0,8}([9|10|13]);)';

		               $pattern .= ')*';
	            	}
	            	$pattern .= $ra[$i][$j];
	        	}
	         	$pattern .= '/i';
	         	$replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
	         	$val = preg_replace($pattern, $replacement, $val);
	         	if ($val_before == $val) {
	            	$found = false;
	         	}
	      	}
	   	}
	   return $val;
	}

	/**
	  * 递归的过滤xss,过滤全部的html tag （包括正常的 '<b></b>' 等，性能好 ）
	  */
	public function d_xss_clean($data) {
	 	if(is_array($data)) {
	 		foreach ($data as $k=>$v) {
	 			$data[$k] = $this->d_xss_clean($v);
	 		}
	 	} else {
	 		$data = htmlspecialchars($data);
	 	}
	 	return $data;
	 }

	/**
	 * 递归的过滤xss,只过滤危险的script
	 */
	public function d_xss_clean2($data) {
	 	if (is_array($data)) {
	 		foreach ($data as $k=>$v) {
	 			$data[$k] = $this->d_xss_clean2($v);
	 		}
	 	} else {
	 		$data = $this->xss_clean($data);
	 	}
	 	return $data;
	}
}