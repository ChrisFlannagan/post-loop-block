const flannyPLB = {
    blocks: false
};

const flannyPLBState = {
    block: false,
    direction: 'next',
    loading: false,
};

const loadPLBResponse = (data) => {
    let postHtml = '';
    for (const post of data) {
        console.log(post);
        postHtml = `${postHtml}
        <div class="flanny-plb-post">
            <a href="${post.link}"
               class="title"
               aria-label="${post.title.rendered}">
                <h3>${post.title.rendered}</h3>
            </a>
            <div class="byline">
		<span>By: ${post.author} - ${post.date}</span>
            </div>
            <div class="excerpt">${post.excerpt.rendered}</div>
        </div>`;
    }

    flannyPLBState.block.querySelector('.posts').innerHTML = postHtml;
};

const flannyPLBRequest = (perPage, page) => {
    if (flannyPLBState.loading) {
        return;
    }

    if (flannyPLBState.direction === 'next') {
        page = Number(page) + 1;
        flannyPLBState.block.setAttribute('data-page', page);
    }

    const data = {
        action:  FlannyPostLoopBlock.action,
        perPage: perPage,
        page:    page,
    };

    flannyPLBState.loading = true;
    fetch(`/wp-json/wp/v2/posts/?per_page=${perPage}&page=${page}`)
    .then(response => response.json())
    .then((data => {
        loadPLBResponse(data);
        flannyPLBState.loading = false;
    }));
};

const flannyPLBPagination = () => {
    for (const block of flannyPLB.blocks) {
        flannyPLBState.block = block;
        const prevBtn = block.querySelector('.wp-block-flanny-post-loop-block-btn-prev');
        const nextBtn = block.querySelector('.wp-block-flanny-post-loop-block-btn-next');
        prevBtn.addEventListener('click', (b) => {
            const block = b.target.closest(`[data-js=${FlannyPostLoopBlock.blockJs}]`);
            flannyPLBState.direction = 'prev';
            flannyPLBRequest(block.getAttribute('data-per-page'), block.getAttribute('data-page'));
        });
        nextBtn.addEventListener('click', (b) => {
            const block = b.target.closest(`[data-js=${FlannyPostLoopBlock.blockJs}]`);
            flannyPLBState.direction = 'next';
            flannyPLBRequest(block.getAttribute('data-per-page'), block.getAttribute('data-page'));
        });
    }
};

const flannyPLBInit = () => {
    flannyPLB.blocks = document.querySelectorAll(`[data-js=${FlannyPostLoopBlock.blockJs}]`);
    flannyPLBPagination();
};

document.addEventListener('DOMContentLoaded', () => {
    flannyPLBInit();
});
