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
final class RatingBBCode extends AbstractBBCode {
	/**
	 * @inheriDoc
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) : string {
		$content = MessageUtil::stripCrap(StringUtil::trim($content));
		$ratingSummary = StringUtil::trim($openingTag['attributes'][0] ?? '');
		$ratingCardOnly = StringUtil::trim($openingTag['attributes'][1] ?? '1');

		// hide content
		$ratingContent = '';
		if ($ratingCardOnly == 1) {
			$ratingContent = '<div class="rating-content">' . $content . '</div>';
		} 

		// get integer
		$ratingSummaryInt = str_replace(',', '.', $ratingSummary);
	
		// get integral
		$ratingIntegral = round($ratingSummaryInt,0);

		// get language
		$ratingLegend = WCF::getLanguage()->get('wcf.bbcode.rating');
		$ratingBase= WCF::getLanguage()->get('wcf.bbcode.rating.base');
		$ratingBaseShort= WCF::getLanguage()->get('wcf.bbcode.rating.base.short');
		$ratingConclusion = WCF::getLanguage()->get('wcf.bbcode.rating.stars.' . round($ratingSummaryInt,0));

		// build rating
		$ratingRounded = round($ratingSummaryInt * 2) / 2;
		$ratingStars = '';
		for ($ratingMin = 1; $ratingMin <= 5; $ratingMin++) {
			if($ratingRounded < $ratingMin ) {
				if(is_float($ratingRounded) && (round($ratingRounded) == $ratingMin)){
					$ratingStars .= "<fa-icon name=\"star-half-stroke\"></fa-icon>";
				} else {
					$ratingStars .= "<fa-icon name=\"star\"></fa-icon>";
				}
			 } else {
				$ratingStars .= "<fa-icon name=\"star\" solid></fa-icon>";
			 }
		}

		// output
		if ($parser->getOutputType() == 'text/html') {
			return <<<HTML
			<div class="rating-wrapper rating-color-scheme-{$ratingIntegral} rating-wrapper-content-{$ratingCardOnly}">
				<div class="rating-badge">
					<div class="rating-badge-legend">{$ratingLegend}</div>
					<div class="rating-badge-summary">{$ratingSummary}<span>{$ratingBaseShort}</span></div>
					<div class="rating-badge-conclusion">{$ratingConclusion}</div>
					<div class="rating-badge-stars">{$ratingStars}</div>
				</div>
				{$ratingContent}
			</div>
			HTML;
		} elseif ($parser->getOutputType() == 'text/simplified-html') {
			return '<div class="rating-wrapper-short">' . $ratingLegend . ': ' . $ratingSummary . ' ' . $ratingBase . ' - ' . $ratingConclusion . '</div><div> ' . $content . '</div>';
		} else {
			return $ratingLegend . ': ' . $ratingSummary . ' ' . $ratingBase . ' - ' . $ratingConclusion;
		}
		return '';
	}
}