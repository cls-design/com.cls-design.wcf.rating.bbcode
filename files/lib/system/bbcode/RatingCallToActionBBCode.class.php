<?php

namespace wcf\system\bbcode;
use wcf\system\WCF;
use wcf\util\MessageUtil;
use wcf\util\StringUtil;

/**
 * ProgressBBCode.
 * 
 * @package		com.cls-design.wcf.rating.bbcode
 * @copyright	www.cls-design.com
 * @author		www.cls-design.com
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
final class RatingCallToActionBBCode extends AbstractBBCode {
	/**
	 * @inheriDoc
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) : string {
		$content = MessageUtil::stripCrap(StringUtil::trim($content));

		// output
		if ($parser->getOutputType() == 'text/html') {
			return <<<HTML
			<div class="rating-cta-button">
				{$content}
			</div>
			HTML;
		} elseif ($parser->getOutputType() == 'text/simplified-html') {
			return $content;
		} else {
			return $content;
		}
		return '';
	}
}