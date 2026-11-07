<?php
/**
 * This file contains the period for the last four weeks.
 *
 * @package threadi-now-pages
 */

declare(strict_types=1);

namespace ThreadiNowPages\Digests\Periods;

// prevent direct access.
defined( 'ABSPATH' ) || exit;

use ThreadiNowPages\Digests\Period_Base;

/**
 * Object for the period of the last four weeks.
 *
 * Unlike the month it does not follow the calendar: it always reaches back
 * 28 days from a date, so on the 2nd of a month it still shows the weeks
 * before instead of almost nothing.
 */
class Weeks4 extends Period_Base {
	/**
	 * The slug of this period.
	 *
	 * @var string
	 */
	protected string $slug = '4weeks';

	/**
	 * Return how many days this period covers.
	 *
	 * @return int
	 */
	protected function get_days(): int {
		return 28;
	}

	/**
	 * Return the period label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return __( 'Last 4 weeks', 'threadi-now-pages' );
	}

	/**
	 * Return a short description of what this period covers.
	 *
	 * @return string
	 */
	public function get_description(): string {
		return __( 'The 28 days up to and including a date.', 'threadi-now-pages' );
	}

	/**
	 * Return the raw window this period covers.
	 *
	 * @param array<string,mixed> $args The resolved arguments.
	 *
	 * @return array{after:string,before:string}
	 */
	public function get_range( array $args ): array {
		$timestamp = $this->get_timestamp( $args );

		// the date itself counts as the last of these days.
		$first = $timestamp - ( ( $this->get_days() - 1 ) * DAY_IN_SECONDS );

		return array(
			'after'  => gmdate( 'Y-m-d', $first ) . ' 00:00:00',
			'before' => gmdate( 'Y-m-d', $timestamp ) . ' 23:59:59',
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function get_note( array $args, array $range ): string {
		// name the dates unless the window ends today.
		if ( gmdate( 'Y-m-d', $this->get_timestamp( $args ) ) === current_time( 'Y-m-d' ) ) {
			return __( 'From the last 4 weeks', 'threadi-now-pages' );
		}

		return parent::get_note( $args, $range );
	}
}
