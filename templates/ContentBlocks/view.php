<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContentBlock $contentBlock
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Content Block'), ['action' => 'edit', $contentBlock->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Content Block'), ['action' => 'delete', $contentBlock->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contentBlock->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Content Blocks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Content Block'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="contentBlocks view content">
            <h3><?= h($contentBlock->label) ?></h3>
            <table>
                <tr>
                    <th><?= __('Parent') ?></th>
                    <td><?= h($contentBlock->parent) ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($contentBlock->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('Label') ?></th>
                    <td><?= h($contentBlock->label) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($contentBlock->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($contentBlock->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($contentBlock->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($contentBlock->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Value') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($contentBlock->value)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Previous Value') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($contentBlock->previous_value)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Phinxlog') ?></h4>
                <?php if (!empty($contentBlock->phinxlog)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Version') ?></th>
                            <th><?= __('Migration Name') ?></th>
                            <th><?= __('Start Time') ?></th>
                            <th><?= __('End Time') ?></th>
                            <th><?= __('Breakpoint') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($contentBlock->phinxlog as $phinxlog) : ?>
                        <tr>
                            <td><?= h($phinxlog->version) ?></td>
                            <td><?= h($phinxlog->migration_name) ?></td>
                            <td><?= h($phinxlog->start_time) ?></td>
                            <td><?= h($phinxlog->end_time) ?></td>
                            <td><?= h($phinxlog->breakpoint) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Phinxlog', 'action' => 'view', $phinxlog->version]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Phinxlog', 'action' => 'edit', $phinxlog->version]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Phinxlog', 'action' => 'delete', $phinxlog->version],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $phinxlog->version),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>