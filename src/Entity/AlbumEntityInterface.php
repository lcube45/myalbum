<?php

namespace Drupal\myalbum\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Album entities.
 *
 * @ingroup myalbum
 */
interface AlbumEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Album name.
   *
   * @return string
   *   Name of the Album.
   */
  public function getName();

  /**
   * Sets the Album name.
   *
   * @param string $name
   *   The Album name.
   *
   * @return \Drupal\myalbum\Entity\AlbumEntityInterface
   *   The called Album entity.
   */
  public function setName($name);

  /**
   * Gets the Album creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Album.
   */
  public function getCreatedTime();

  /**
   * Sets the Album creation timestamp.
   *
   * @param int $timestamp
   *   The Album creation timestamp.
   *
   * @return \Drupal\myalbum\Entity\AlbumEntityInterface
   *   The called Album entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Album published status indicator.
   *
   * Unpublished Album are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Album is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Album.
   *
   * @param bool $published
   *   TRUE to set this Album to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\myalbum\Entity\AlbumEntityInterface
   *   The called Album entity.
   */
  public function setPublished($published);

  /**
   * Gets the Album revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Album revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\myalbum\Entity\AlbumEntityInterface
   *   The called Album entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Album revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Album revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\myalbum\Entity\AlbumEntityInterface
   *   The called Album entity.
   */
  public function setRevisionUserId($uid);

}
