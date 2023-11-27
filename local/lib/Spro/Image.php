<?

namespace Spro;


use CFile;
use CUtil;
use Exception;

class Image
{
	public static function ResizeImageGet ( $imgId, $sizes )
	{
		try{
			$img = CFile::ResizeImageGet( $imgId, $sizes );
		}
		catch (Exception $e)
		{
			$img['src'] = CFile::GetPath( $imgId );
		}

		return $img;
	}

	/**
	 * @param string $svgCode
	 * @param string $addClass
	 * @param string $attr
	 */
	public static function showSVG(string $svgCode, string $addClass = "", string $attr = "")
	{
		echo self::generateSVG($svgCode, $addClass, $attr);
	}

	/**
	 * @param string $svgCode
	 * @param string $addClass
	 * @param string $attr
	 *
	 * @return string
	 */
	public static function generateSVG(string $svgCode, string $addClass = "", string $attr = ""): string
	{
		if ($addClass)
		{
			$addClass = ' ' . $addClass;
		}

		return '<svg class="icon icon-' . $svgCode . $addClass . '" ' . $attr . '>
			<use xlink:href="' . CUtil::GetAdditionalFileURL(self::getSvgPath()) . '#' . self::generateIconCode($svgCode) . '"></use>
			</svg>';
	}

	function placeholder($width, $height): string
	{
		return "data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20{$width}%20{$height}%22%3E%3C%2Fsvg%3E";
	}

	private static function getSvgPath()
	{
		return SITE_TEMPLATE_PATH . '/img/sprite.svg';
	}

	private static function generateIconCode($svgCode)
	{
		return 'icon-' . $svgCode;
	}
}
