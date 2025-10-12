<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\ContentBlocks\Model\Entity\ContentBlock> $contentBlocksGrouped
 */

$this->assign('title', 'Content Blocks');

$this->Html->css('ContentBlocks.content-blocks', ['block' => true]);

$slugify = function($text) {
    return preg_replace('/[^A-Za-z0-9-]+/', '-', $text);
}

?>
<div class="contentBlocks index content">

    <?php
    /*
    // TODO: Think of a way to allow this for developers, but not for the actual website. Adding a content block doesn't
    //       mean anything for end users - it needs to be hard coded into a template somewhere to make sense. Perhaps
    //       it can just be guarded behind a DEBUG flag with an appropriate confirm() dialog warning that it needs to
    //       be used in a template after being added...
    echo $this->Html->link(__('New Content Block'), ['action' => 'add'], ['class' => 'button button-outline float-right'])
    */
    ?>

    <h3><?= __('Content Blocks') ?></h3>

    <div class="d-flex align-items-center gap-2 mb-3">
        <label for="cb-filter" class="form-label mb-0 me-2">Filter blocks</label>
        <input id="cb-filter" type="search" class="form-control" placeholder="Search by title, slug, or content…" style="max-width: 420px;">
    </div>

    <?php
    $allBlocks = [];
    foreach ($contentBlocksGrouped as $group) {
        foreach ($group as $block) {
            $allBlocks[] = $block;
        }
    }
    ?>

    <ul class="content-blocks--list-group">
        <?php foreach ($allBlocks as $contentBlock): ?>
            <li class="content-blocks--list-group-item">
                <div class="content-blocks--text">
                    <div class="content-blocks--display-name">
                        <?= h($contentBlock->label) ?>
                    </div>
                    <div class="content-blocks--description">
                        <?= h($contentBlock->description) ?>
                    </div>
                </div>
                <div class="content-blocks--actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contentBlock->id]) ?>
                    <?php if (!empty($contentBlock->previous_value)): ?>
                        <?= ' :: ' . $this->Form->postLink(
                            __('Restore'),
                            ['action' => 'restore', $contentBlock->id],
                            ['confirm' => __("Are you sure you want to restore the previous version for this item?\n{0}/{1}\nNote: You cannot cancel this action!", $contentBlock->parent, $contentBlock->slug)]
                        ) ?>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

</div>
