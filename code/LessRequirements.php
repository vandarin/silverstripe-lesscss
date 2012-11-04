<?php
class LessRequirements extends Requirements_Backend {

	function css($file, $media = null) {
		if (preg_match('/\.less$/i', $file)) {
			$out = preg_replace('/\.less$/i', '.css', $file);
			lessc::ccompile(Director::getAbsFile($file), Director::getAbsFile($out));
			$file = $out;			
		}
		return parent::css($file, $media);
	}

}