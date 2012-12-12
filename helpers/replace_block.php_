<?php defined("SYSPATH") or die("No direct script access.");
/**
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2012 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */
class replace_block {
  static function get_site_list() {
    return array(
      "replace_site" => t("Replace Sidebar Block"));
  }

  static function get_admin_list() {
    return array(
      "replace_admin" => t("Replace Dashboard Block"));
  }

  static function get($block_id, $theme) {
    $block = new Block();
    switch ($block_id) {
    case "replace_admin":
      $block->css_id = "g-Replace-admin";
      $block->title = t("replace Dashboard Block");
      $block->content = new View("admin_replace_block.html");

      $block->content->item = ORM::factory("item", 1);
      break;
    case "replace_site":
      $block->css_id = "g-Replace-site";
      $block->title = t("replace Sidebar Block");
      $block->content = new View("replace_block.html");

      $block->content->item = ORM::factory("item", 1);
      break;
    }
    return $block;
  }
}
