<?php

namespace wcf\system\bbcode;

use wcf\system\style\FontAwesomeIcon;
use wcf\system\WCF;
use wcf\util\MessageUtil;
use wcf\util\StringUtil;

/**
 * Rating BBCode.
 * 
 * @package		com.cls-design.wcf.rating.bbcode
 * @copyright	www.cls-design.com
 * @author		www.cls-design.com
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 */
final class RatingBarBBCode extends AbstractBBCode {
	/**
	 * @inheriDoc
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) : string {
		$content = MessageUtil::stripCrap(StringUtil::trim($content));
		$ratingSummary = (int) ($openingTag['attributes'][0] ?? '');

		// check
		if ((1 <= $ratingSummary ) && ($ratingSummary  <= 5)) {
			$ratingSummary = $ratingSummary;
		} else {
			$ratingSummary = 0;
		}

		// get empty stars
		$ratingEmptyStars = 5 - round($ratingSummary,0);

		// get language
		$ratingStarsLegend = WCF::getLanguage()->get('wcf.bbcode.rating.base');
		$ratingLegend = WCF::getLanguage()->get('wcf.bbcode.rating');

		// build rating
		$ratingStars = '';
		$ratingStars = str_repeat(FontAwesomeIcon::fromValues('star', true)->toHtml(), $ratingSummary) . str_repeat(FontAwesomeIcon::fromValues('star')->toHtml(), $ratingEmptyStars);

		// output
		if ($parser->getOutputType() == 'text/html') {
			return <<<HTML
			<div class="rating-bar-wrapper">
				<div class="rating-bar-content">
					{$content}
				</div>
				<div class="rating-bar-spacer"><div></div></div>
				<div class="rating-bar-stars">
					{$ratingStars} {$ratingSummary} {$ratingStarsLegend}
				</div>
			</div>
			HTML;
		} elseif ($parser->getOutputType() == 'text/simplified-html') {
			return '<div class="rating-bar-wrapper-short">' . $ratingLegend . ' - '. $content . ': ' . $ratingSummary . ' ' . $ratingStarsLegend . '</div>';
		} else {
			return $ratingLegend . ' - '. $content . ': ' . $ratingSummary . ' ' . $ratingStarsLegend . '\r\n';
		}
		return '';
	}
}