<?php
/**
 * @file
 * Contains the SocialitejsLink class.
 */

namespace Drupal\socialitejs;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Path\AliasStorageInterface;

class SocialitejsLink {

  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The alias storage.
   *
   * @var \Drupal\Core\Path\AliasStorageInterface
   */
  protected $aliasStorage;

  /**
   * The config factory.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Path\AliasStorageInterface $alias_storage
   *   The alias storage.
   */
  public function __construct(ConfigFactoryInterface $config_factory, AliasStorageInterface $alias_storage) {
    $this->configFactory = $config_factory;
    $this->aliasStorage = $alias_storage;
  }

  public function getLink($site, $node) {
    global $base_url;
    // check for an alias on the node
    if (!isset($node->link)) {
      $alias = $this->aliasStorage->lookupPathAlias('node/'. $node->nid, 'en');
      $url = $base_url .'/'. ($alias ? $alias : 'node/'. $node->nid);
    }
    else {
      $url = $node->link;
    }

    $title = $node->title;
    $link = array();
    $socialitejs_config = $this->configFactory->get('socialitejs.settings');
    $box = $socialitejs_config->get('socialitejs_layout');

    switch($site)
      {
        case 'facebook':
          if($box)
            $options = array('attributes' => array('class' => 'socialite facebook-like', 'data-href' => $url, 'data-layout' => 'box_count'));
          else
            $options = array('attributes' => array('class' => 'socialite facebook-like', 'data-href' => $url));
          $link = array(
            '#type'    => 'link',
            '#title'   => 'Facebook',
            '#href'    => 'http://www.facebook.com/sharer.php?u='.$url.'&amp;t='.$title,
            '#options' => $options,
            '#suffix'  => '&nbsp;',
          );
          break;
        case 'twitter':
          if($box)
            $options = array('attributes' => array('class' => 'socialite twitter-share', 'data-url' => $url, 'data-count' => 'vertical'));
          else
            $options = array('attributes' => array('class' => 'socialite twitter-share', 'data-url' => $url));
          $link = array(
            '#type'    => 'link',
            '#title'   => 'Twitter',
            '#href'    => 'http://twitter.com/share',
            '#options' => $options,
            '#suffix'  => '&nbsp;',
          );
          break;
        case 'googleplus':
          if($box)
            $options = array('attributes' => array('class' => 'socialite googleplus-one', 'data-href' => $url, 'data-size' => 'tall'));
          else
            $options = array('attributes' => array('class' => 'socialite googleplus-one', 'data-href' => $url, 'data-size' => 'tall', 'data-annotation' => 'inline'));
          $link = array(
            '#type'    => 'link',
            '#title'   => 'Google+',
            '#href'    => 'https://plus.google.com/share?url='.$url,
            '#options' => $options,
            '#suffix'  => '&nbsp;',
          );
          break;
        case 'linkedin':
          if($box)
            $options = array('attributes' => array('class' => 'socialite linkedin-share', 'data-url' => $url, 'data-counter' => 'top'));
          else
            $options = array('attributes' => array('class' => 'socialite linkedin-share', 'data-url' => $url, 'data-counter' => 'right'));
          $link = array(
            '#type'    => 'link',
            '#title'   => 'LinkedIn',
            '#href'    => 'http://www.linkedin.com/shareArticle?mini=true&amp;url='.$url.'&amp;title='.$title,
            '#options' => $options,
            '#suffix'  => '&nbsp;',
          );
          break;
      }
    return $link;
  }
}
