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

    <div class="mb-3">
        <label for="cb-search" class="sr-only"><?= __('Search content blocks') ?></label>
        <input
            type="search"
            id="cb-search"
            class="form-control"
            placeholder="<?= __('Search blocks by name or description…') ?>"
            autocomplete="off"
            aria-describedby="cb-search-help cb-results-count"
        >
        <small id="cb-search-help" class="form-text text-muted">
            <?= __('Type to filter. Showing only matching blocks.') ?>
        </small>
        <div id="cb-results-count" class="mt-1 text-muted"></div>
    </div>

    <?php
    // Flatten grouped array into one list ($contentBlocksGrouped => $allBlocks)
    $allBlocks = [];
    foreach ($contentBlocksGrouped as $group) {
        foreach ($group as $block) {
            $allBlocks[] = $block;
        }
    }
    // (Optional) sort by label
    usort($allBlocks, fn($a, $b) => strcmp($a->label, $b->label));
    ?>

    <ul id="cb-list" class="content-blocks--list-group">
        <?php foreach ($allBlocks as $contentBlock): ?>
            <li class="content-blocks--list-group-item" data-search-text="<?= h(mb_strtolower(($contentBlock->label ?? '') . ' ' . ($contentBlock->description ?? ''))) ?>">
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

    <p id="cb-empty" class="text-muted" style="display:none;"><?= __('No content blocks match your search.') ?></p>

    <?php // Tiny, framework-free filter script ?>
    <script>
        (function () {
            const input = document.getElementById('cb-search');
            const list  = document.getElementById('cb-list');
            const items = Array.from(list.querySelectorAll('.content-blocks--list-group-item'));
            const empty = document.getElementById('cb-empty');
            const count = document.getElementById('cb-results-count');

            // Debounce for comfort
            let t;
            function debounced(fn, delay=120){ clearTimeout(t); t=setTimeout(fn, delay); }

            function update() {
                const q = (input.value || '').toLowerCase().trim();
                let visible = 0;

                if (!q) {
                    items.forEach(li => li.style.display = '');
                    empty.style.display = 'none';
                    count.textContent = `<?= __('Showing {0} blocks', [count($allBlocks)]) ?>`;
                    return;
                }

                items.forEach(li => {
                    const hay = li.getAttribute('data-search-text') || '';
                    const show = hay.includes(q);
                    li.style.display = show ? '' : 'none';
                    if (show) visible++;
                });

                empty.style.display = visible ? 'none' : '';
                count.textContent = `<?= __('Showing {0} of {1} blocks') ?>`.replace('{0}', visible).replace('{1}', <?= (int)count($allBlocks) ?>);
            }

            input.addEventListener('input', () => debounced(update));
            // Initialise count on load
            update();

            // Optional: allow ?q=foo to prefill search
            const params = new URLSearchParams(location.search);
            if (params.has('q')) {
                input.value = params.get('q');
                update();
            }
        })();
    </script>


</div>
