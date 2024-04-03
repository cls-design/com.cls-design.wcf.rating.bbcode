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
final class RatingArgumentsBBCode extends AbstractBBCode {
	/**
	 * @inheriDoc
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) : string {
		$content = MessageUtil::stripCrap(StringUtil::trim($content));

		// get language
		$ratingArgumentsPositive = WCF::getLanguage()->get('wcf.bbcode.rating.arguments.positive');
		$ratingArgumentsNegative = WCF::getLanguage()->get('wcf.bbcode.rating.arguments.negative');
		$ratingArgumentsShort = WCF::getLanguage()->get('wcf.bbcode.rating.arguments.short');

		// output
		if ($parser->getOutputType() == 'text/html') {
			return <<<HTML
			<div class="rating-arguments-wrapper">
				<div class="rating-arguments-title">
					<div>{$ratingArgumentsPositive}</div>
					<div>{$ratingArgumentsNegative}</div>
				</div>
				<div class="rating-arguments-content">
					{$content}
				</div>
			</div>
			HTML;
		} elseif ($parser->getOutputType() == 'text/simplified-html') {
			return '<div class="rating-arguments-wrapper">' . $ratingArgumentsShort . '</div>';
		} else {
			return $ratingArgumentsShort;
		}
		return '';
	}
}