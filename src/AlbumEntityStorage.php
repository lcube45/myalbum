<?php

namespace Drupal\myalbum;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\myalbum\Entity\AlbumEntityInterface;

/**
 * Defines the storage handler class for Album entities.
 *
 * This extends the base storage class, adding required special handling for
 * Album entities.
 *
 * @ingroup myalbum
 */
class AlbumEntityStorage extends SqlContentEntityStorage implements AlbumEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(AlbumEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {album_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {album_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(AlbumEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {album_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('album_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
