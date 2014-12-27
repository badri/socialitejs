<?php

/**
 * @file
 * Contains \Drupal\socialitejs\Plugin\Block\SocialitejsBlock.
 */

namespace Drupal\socialitejs\Plugin\Block;

use Drupal\block\BlockBase;
use Drupal\Core\Url;

/**
 * Provides a 'Socialite.js' block with buttons and count.
 *
 * @Block(
 *   id = "socialitejs",
 *   admin_label = @Translation("Socialite.js buttons"),
 * )
 */
class SocialitejsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $socialitejs_config = \Drupal::config('socialitejs.settings');

      $node = new stdClass;

      $node->link = Url::fromRoute('<current>', array(), array('absolute' => TRUE));

          $request = \Drupal::request();
          $route = $request->attributes->get(RouteObjectInterface::ROUTE_OBJECT);
          $node->title = \Drupal::service('title_resolver')->getTitle($request, $route);

      $sites = $socialitejs_config->get('socialitejs_sites');
      foreach ($sites as $site => $enabled) {
        if ($enabled) {
          $items[] = array(
            '#markup' => drupal_render(_socialitejs_link($site, $node)),
            '#wrapper_attributes' => array('class' => array('socialite-item')),
          );
        }
      }

      $attributes = array('class' => array('socialitejs', 'layout' . $socialitejs_config->get('socialitejs_layout')));

    return array(
      '#theme' => 'item_list',
      '#items' => $items,
      '#attributes' => $attributes
      ),
    );
  }
}
