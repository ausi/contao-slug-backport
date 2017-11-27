<?php

if (isset($GLOBALS['TL_DCA']['tl_calendar_events']['fields']['alias']['save_callback'])) {
	foreach($GLOBALS['TL_DCA']['tl_calendar_events']['fields']['alias']['save_callback'] as $key => $callback) {
		if (is_array($callback) && $callback[0] === 'tl_calendar_events' && $callback[1] === 'generateAlias') {
			$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['alias']['save_callback'][$key][0] = 'Ausi\ContaoSlugBackport\Callbacks';
			$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['alias']['save_callback'][$key][1] = 'calendarGenerateAlias';
		}
	}
}
