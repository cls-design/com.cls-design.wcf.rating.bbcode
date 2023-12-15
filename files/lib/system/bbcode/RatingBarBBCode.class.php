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
final class RatingBarBBCode extends AbstractBBCode {
	/**
	 * @inheriDoc
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) : string {
		$content = MessageUtil::stripCrap(StringUtil::trim($content));
		$ratingSummary = StringUtil::trim($openingTag['attributes'][0] ?? '');

		// convert to integer
		$ratingSummaryInt = str_replace(',', '.', $ratingSummary);

		// get integral
		$ratingResult = round($ratingSummaryInt,0);

		// get empty stars
		$ratingEmptyStars = 5 - round($ratingSummaryInt,0);

		// get language
		$ratingStarsLegend = WCF::getLanguage()->get('wcf.bbcode.rating.base');
		$ratingLegend = WCF::getLanguage()->get('wcf.bbcode.rating');

		// build rating
		$ratingStars = '';
		$ratingStars = str_repeat('<fa-icon name="star" solid></fa-icon>', $ratingResult) . str_repeat('<fa-icon name="star"></fa-icon>', $ratingEmptyStars);

		// output
		if ($parser->getOutputType() == 'text/html') {
			return <<<HTML
			<div class="rating-bar-wrapper">
				<div class="rating-bar-content">
					{$content}
				</div>
				<div class="rating-bar-spacer"><div></div></div>
				<div class="rating-bar-stars">
					{$ratingStars} {$ratingResult} {$ratingStarsLegend}
				</div>
			</div>
			HTML;
		} elseif ($parser->getOutputType() == 'text/simplified-html') {
			return '<div class="rating-bar-wrapper-short">' . $ratingLegend . ' - '. $content . ': ' . $ratingResult . ' ' . $ratingStarsLegend . '</div>';
		} else {
			return $ratingLegend . ' - '. $content . ': ' . $ratingResult . ' ' . $ratingStarsLegend . '\r\n';
		}
		return '';
	}
}