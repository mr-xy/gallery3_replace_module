<?php defined("SYSPATH") or die("No direct script access.");/**
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
class replace_event {
  static function add_photos_form($album, $form) {
  }

  static function add_photos_form_completed($item, $form) {
  }

  static function admin_menu($admin_menu, $theme) {
  }

  static function after_combine($type, $contents) {
  }

  static function album_add_form($parent, $form) {
  }

  static function album_add_form_completed($album, $form) {
  }

  static function album_menu($menu, $album_menu) {
  }

  static function batch_complete() {
  }

  static function before_combine($type, $before_combine, $type, $group) {
  }

  static function captcha_protect_form($form) {
  }

  static function comment_add_form($form) {
  }

  static function comment_created($comment_created) {
  }

  static function comment_updated($original, $comment_updated) {
  }

  static function context_menu($menu, $context_menu, $item, $thumbnail_css_selector) {
      if (access::can("edit", $item)) {
          if ($item->is_photo() || $item->is_movie()) {
            $menu->get("options_menu")
              ->append(Menu::factory("dialog")
                       ->id("replace")
                       ->label(t("Replace"))
                       ->css_class(".ui-icon-transfer-e-w")
                       ->url(url::site("replace/index/{$item->id}")));
          }
      }
  }

  static function gallery_ready() {
  }

  static function gallery_shutdown() {
  }

  static function graphics_composite($input_file, $output_file, $options, $item) {
  }

  static function graphics_composite_completed($input_file, $output_file, $options, $item) {
  }

  static function graphics_resize($input_file, $output_file, $options, $item) {
  }

  static function graphics_resize_completed($input_file, $output_file, $options, $item) {
  }

  static function graphics_rotate($input_file, $output_file, $options, $item) {
  }

  static function graphics_rotate_completed($input_file, $output_file, $options, $item) {
  }

  static function group_before_delete($group_before_delete) {
  }

  static function group_created($group_created) {
  }

  static function group_deleted($old) {
  }

  static function group_updated($original, $group_updated) {
  }

  static function identity_provider_changed($current_provider, $new_provider) {
  }

  static function info_block_get_metadata($block, $theme) {
  }

  static function item_before_create($item_before_create) {
  }

  static function item_before_delete($item_before_delete) {
  }

  static function item_before_update($item) {
  }

  static function item_created($item_created) {
  }

  static function item_deleted($old) {
  }

  static function item_edit_form($parent, $form) {
  }

  static function item_edit_form_completed($album, $form) {
  }

  static function item_index_data($item, $data) {
  }

  static function item_moved($item_moved, $original) {
  }

  static function item_related_update($item) {
  }

  static function item_updated($original, $item_updated) {
  }

  static function item_updated_data_file($item_updated_data_file) {
  }

  static function module_change($changes) {
  }

  static function movie_menu($menu, $movie_menu) {
  }

  static function photo_menu($menu, $photo_menu) {
  }

  static function pre_deactivate($data) {
  }

  static function show_user_profile($event_data) {
  }

  static function site_menu($menu, $site_menu, $item_css_selector) {
    #$item = $theme->item();
    if (!empty($item) && access::can("edit", $item)) {
        if ($item->is_photo() || $item->is_movie()) {
            $menu->get("options_menu")
              ->append(Menu::factory("dialog")
                       ->id("replace")
                       ->label(t("Replace"))
                       ->css_class(".ui-icon-transfer-e-w")
                       ->url(url::site("replace/index/{$item->id}")));
        }
    }
  }

  static function tag_menu($menu, $tag_menu) {
  }

  static function theme_edit_form($form) {
  }

  static function theme_edit_form_completed($form) {
  }

}
