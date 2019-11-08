const flannyPLBState = {
    block: false,
    direction: '',
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
        <span>By: ${post.plb_author_link} - ${post.plb_formatted_date}</span>
            </div>
            <div class="excerpt">${post.excerpt.rendered}</div>
        </div>`;
    }

    flannyPLBState.block.querySelector('.posts').innerHTML = postHtml;
    flannyPLBState.block = false;
    flannyPLBState.loading = false;
    flannyPLBState.direction = '';
};

const flannyPLBHideShowBtns = (page) => {
    if (page === Number(flannyPLBState.block.getAttribute('data-total-pages'))) {
        flannyPLBState.block.querySelector('.wp-block-flanny-post-loop-block-btn-next').style.display = 'none';
    } else {
        flannyPLBState.block.querySelector('.wp-block-flanny-post-loop-block-btn-next').style.display = 'inline-block';
    }

    if (page === 1) {
        flannyPLBState.block.querySelector('.wp-block-flanny-post-loop-block-btn-prev').style.display = 'none';
    } else {
        flannyPLBState.block.querySelector('.wp-block-flanny-post-loop-block-btn-prev').style.display = 'inline-block';
    }
};

const flannyPLBRequest = () => {
    if (flannyPLBState.loading || flannyPLBState.block === false ) {
        return;
    }

    perPage = Number(flannyPLBState.block.getAttribute('data-per-page'));
    page = Number(flannyPLBState.block.getAttribute('data-page'));
    page += ((flannyPLBState.direction === 'next') ? 1 : -1);
    flannyPLBHideShowBtns(page);

    flannyPLBState.block.setAttribute('data-page', page);
    flannyPLBState.loading = true;

    fetch(`/wp-json/wp/v2/posts/?per_page=${perPage}&page=${page}`)
    .then(response => response.json())
    .then((data => {
        loadPLBResponse(data);
    }));
};

const flannyPLBPagination = () => {
    document.addEventListener('click', (e) => {
        e.stopPropagation();
        if (e.target && e.target.classList.contains('wp-block-flanny-post-loop-block-btn-next') ) {
            flannyPLBState.direction = 'next';
        } else if (e.target && e.target.classList.contains('wp-block-flanny-post-loop-block-btn-prev')) {
            flannyPLBState.direction = 'prev';
        }

        if ('' === flannyPLBState.direction) {
            return;
        }

        flannyPLBState.block = e.target.closest(`[data-js=${FlannyPostLoopBlock.blockJs}]`);
        flannyPLBRequest();
    });
};

// doc ready, fire it up
document.addEventListener('DOMContentLoaded', () => {
    flannyPLBPagination();
});
