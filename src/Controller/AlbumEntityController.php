<?php

namespace Drupal\myalbum\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\myalbum\Entity\AlbumEntityInterface;

/**
 * Class AlbumEntityController.
 *
 *  Returns responses for Album routes.
 */
class AlbumEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Album  revision.
   *
   * @param int $album_revision
   *   The Album  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($album_revision) {
    $album = $this->entityManager()->getStorage('album')->loadRevision($album_revision);
    $view_builder = $this->entityManager()->getViewBuilder('album');

    return $view_builder->view($album);
  }

  /**
   * Page title callback for a Album  revision.
   *
   * @param int $album_revision
   *   The Album  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($album_revision) {
    $album = $this->entityManager()->getStorage('album')->loadRevision($album_revision);
    return $this->t('Revision of %title from %date', ['%title' => $album->label(), '%date' => format_date($album->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Album .
   *
   * @param \Drupal\myalbum\Entity\AlbumEntityInterface $album
   *   A Album  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(AlbumEntityInterface $album) {
    $account = $this->currentUser();
    $langcode = $album->language()->getId();
    $langname = $album->language()->getName();
    $languages = $album->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $album_storage = $this->entityManager()->getStorage('album');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $album->label()]) : $this->t('Revisions for %title', ['%title' => $album->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all album revisions") || $account->hasPermission('administer album entities')));
    $delete_permission = (($account->hasPermission("delete all album revisions") || $account->hasPermission('administer album entities')));

    $rows = [];

    $vids = $album_storage->revisionIds($album);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\myalbum\AlbumEntityInterface $revision */
      $revision = $album_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $album->getRevisionId()) {
          $link = $this->l($date, new Url('entity.album.revision', ['album' => $album->id(), 'album_revision' => $vid]));
        }
        else {
          $link = $album->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => Url::fromRoute('entity.album.revision_revert', ['album' => $album->id(), 'album_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.album.revision_delete', ['album' => $album->id(), 'album_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['album_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
