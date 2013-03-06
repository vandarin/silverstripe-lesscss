<?php
class LessRequirements extends Requirements_Backend {

	function css($file, $media = null) {
		if (preg_match('/\.less$/i', $file)) {
			$out = preg_replace('/\.less$/i', '.css', $file);
			if(isset($_REQUEST['flush'])) {
				unlink(Director::getAbsFile($out));
			}
			lessc::ccompile(Director::getAbsFile($file), Director::getAbsFile($out));
			$file = $out;
		}
		return parent::css($file, $media);
	}

	public function themedCSS($name, $module = null, $media = null) {
		$path = SSViewer::get_theme_folder();
		$abspath = BASE_PATH . DIRECTORY_SEPARATOR . $path;
		$less = "/css/$name.less";
		$css = "/css/$name.css";
		// Try LESS files first
		if ($module && file_exists($abspath.'_'.$module.$less)) {
			$this->css($path.'_'.$module.$less, $media);
		}
		else if (file_exists($abspath.$less)) {
			$this->css($path.$less, $media);
		}
		else if ($module && file_exists($module.$less)) {
			$this->css($module.$less);
		} else if ($module && file_exists($abspath.'_'.$module.$css)) {
			$this->css($path.'_'.$module.$css, $media);
		}
		else if (file_exists($abspath.$css)) {
			$this->css($path.$css, $media);
		}
		else if ($module) {
			$this->css($module.$css);
		}
	}
}
