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
final class RatingBBCode extends AbstractBBCode {
	/**
	 * @inheriDoc
	 */
	public function getParsedTag(array $openingTag, $content, array $closingTag, BBCodeParser $parser) : string {
		$content = MessageUtil::stripCrap(StringUtil::trim($content));
		$ratingSummary = StringUtil::trim($openingTag['attributes'][0] ?? '');
		$ratingCardOnly = (int) ($openingTag['attributes'][1] ?? '1');

		// hide content
		$ratingContent = '';
		if ($ratingCardOnly == 1) {
			$ratingContent = '<div class="rating-content">' . $content . '</div>';
		} 

		// get float
		$ratingSummaryFloat = str_replace(',', '.', $ratingSummary);
	
		// get integer
		$ratingInteger = round($ratingSummaryFloat,0);
		
		// format summary
		$languageID = '';
		if (WCF::getLanguage()->languageCode == "de" || WCF::getLanguage()->languageCode == "es") {
			$ratingSummaryFormat = str_replace('.', ',', $ratingSummary);
		} else {
			$ratingSummaryFormat = str_replace(',', '.', $ratingSummary);
		}

		// get language
		$ratingLegend = WCF::getLanguage()->get('wcf.bbcode.rating');
		$ratingBase= WCF::getLanguage()->get('wcf.bbcode.rating.base');
		$ratingBaseShort= WCF::getLanguage()->get('wcf.bbcode.rating.base.short');
		$ratingConclusion = WCF::getLanguage()->get('wcf.bbcode.rating.stars.' . round($ratingSummaryFloat,0));

		// build rating
		$ratingRounded = round($ratingSummaryFloat * 2) / 2;
		$ratingStars = '';
		for ($ratingMin = 1; $ratingMin <= 5; $ratingMin++) {
			if($ratingRounded < $ratingMin ) {
				if(is_float($ratingRounded) && (round($ratingRounded) == $ratingMin)){
					$ratingStars .= FontAwesomeIcon::fromValues('star-half-stroke')->toHtml();
				} else {
					$ratingStars .= FontAwesomeIcon::fromValues('star')->toHtml();
				}
			 } else {
				$ratingStars .= FontAwesomeIcon::fromValues('star', true)->toHtml();
			 }
		}

		// output
		if ($parser->getOutputType() == 'text/html') {
			return <<<HTML
			<div class="rating-wrapper rating-color-scheme-{$ratingInteger} rating-wrapper-content-{$ratingCardOnly}">
				<div class="rating-badge">
					<div class="rating-badge-legend">{$ratingLegend}</div>
					<div class="rating-badge-summary">{$ratingSummaryFormat}<span>{$ratingBaseShort}</span></div>
					<div class="rating-badge-conclusion">{$ratingConclusion}</div>
					<div class="rating-badge-stars">{$ratingStars}</div>
				</div>
				{$ratingContent}
			</div>
			HTML;
		} elseif ($parser->getOutputType() == 'text/simplified-html') {
			return '<div class="rating-wrapper-short">' . $ratingLegend . ': ' . $ratingSummaryFormat . ' ' . $ratingBase . ' - ' . $ratingConclusion . '</div><div> ' . $content . '</div>';
		} else {
			return $ratingLegend . ': ' . $ratingSummaryFormat . ' ' . $ratingBase . ' - ' . $ratingConclusion;
		}
		return '';
	}
}