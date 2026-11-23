<?php
/**
 * Shared setup for the about sections (included by each of them).
 */
defined( 'ABSPATH' ) || exit;
// Value tile icons (Lucide: utensils, users, message-circle-check).
$value_icons = array(
	'utensils' => '<svg viewBox="0 0 24 24"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/></svg>',
	'users'    => '<svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
	'check'    => '<svg viewBox="0 0 24 24"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/><path d="m9 12 2 2 4-4"/></svg>',
);

// The grid tiles in page order (= swipe order on phones). Desktop position in the label.
$value_tiles = array(
	array( 'key' => 'act', 'kind' => 'icon', 'class' => 'value--yellow value--act', 'icon' => 'utensils', 'label' => 'Tile 1 · yellow (desktop: middle row, left)', 'title' => 'Act as brand ambassadors', 'text' => 'We champion the quality, heritage, and values of every brand we represent.' ),
	array( 'key' => 'customers', 'kind' => 'icon', 'class' => 'value--red value--customers', 'icon' => 'users', 'label' => 'Tile 2 · red (desktop: top right)', 'title' => 'Customers first', 'text' => 'We prioritise guest satisfaction and franchisee success in everything we do.' ),
	array( 'key' => 'ethics', 'kind' => 'icon', 'class' => 'value--sand value--ethics', 'icon' => 'check', 'label' => 'Tile 3 · sand (desktop: middle row, second)', 'title' => 'High ethical standards', 'text' => 'We conduct business with absolute transparency, honesty, and integrity.' ),
	array( 'key' => 'respect', 'kind' => 'photo', 'class' => 'value--photo value--respect', 'img' => 'team.jpg', 'w' => 1600, 'h' => 968, 'label' => 'Tile 4 · wide photo (desktop: top left)', 'title' => 'Respect one another and value our employees', 'text' => 'We foster an inclusive, supportive workplace where every team member is valued.' ),
	array( 'key' => 'learning', 'kind' => 'photo', 'class' => 'value--photo value--learning', 'img' => 'chicken-university.jpg', 'w' => 1520, 'h' => 776, 'label' => 'Tile 5 · wide photo (desktop: bottom row)', 'title' => 'Foster continuous learning', 'text' => 'We embrace innovation, training, and ongoing professional development.' ),
	array( 'key' => 'give', 'kind' => 'icon', 'class' => 'value--dark value--give', 'icon' => 'users', 'label' => 'Tile 6 · dark, red on phones (desktop: middle row, right)', 'title' => 'Give back to our communities', 'text' => 'We actively enrich and support the neighbourhoods and local communities we serve.' ),
	array( 'key' => 'possible', 'kind' => 'icon', 'class' => 'value--sand value--possible', 'icon' => 'check', 'label' => 'Tile 7 · sand (desktop: bottom left)', 'title' => 'Believe in the power of possible', 'text' => 'We approach expansion and challenges with an ambitious, forward-thinking mindset.' ),
);
?>
