const initMobileMenu = () => {
    const button = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    const barsIcon = document.getElementById('menu-icon-bars');
    const xIcon = document.getElementById('menu-icon-x');

    if (!button || !menu || !barsIcon || !xIcon) {
        return;
    }

    const closeMenu = () => {
        menu.classList.add('hidden');
        barsIcon.classList.remove('hidden');
        xIcon.classList.add('hidden');
    };

    const toggleMenu = () => {
        menu.classList.toggle('hidden');
        barsIcon.classList.toggle('hidden');
        xIcon.classList.toggle('hidden');
    };

    button.addEventListener('click', toggleMenu);

    menu.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', closeMenu);
    });
};

const getProjectsData = () => {
    const element = document.getElementById('projects-data');

    if (!element) {
        return {};
    }

    try {
        return JSON.parse(element.textContent || '{}');
    } catch (error) {
        console.error('Portfolio projects data could not be parsed.', error);
        return {};
    }
};

const getEmbedUrl = (url) => {
    if (!url) {
        return '';
    }

    try {
        const parsedUrl = new URL(url);
        const host = parsedUrl.hostname.replace('www.', '');

        if (host === 'youtube.com' || host === 'm.youtube.com') {
            const videoId = parsedUrl.searchParams.get('v');
            return videoId ? `https://www.youtube.com/embed/${videoId}` : url;
        }

        if (host === 'youtu.be') {
            return `https://www.youtube.com/embed/${parsedUrl.pathname.replace('/', '')}`;
        }
    } catch (error) {
        return url;
    }

    return url;
};

const initPortfolioFilters = () => {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card');

    if (!filterButtons.length || !projectCards.length) {
        return;
    }

    const setActiveFilter = (activeButton) => {
        filterButtons.forEach((button) => {
            button.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
            button.classList.add('bg-slate-900', 'text-slate-400', 'border-slate-800');
        });

        activeButton.classList.remove('bg-slate-900', 'text-slate-400', 'border-slate-800');
        activeButton.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
    };

    const applyFilter = (filterValue) => {
        projectCards.forEach((card) => {
            const matches = filterValue === 'all' || card.getAttribute('data-category') === filterValue;
            card.style.display = matches ? 'flex' : 'none';
        });
    };

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            setActiveFilter(button);
            applyFilter(button.getAttribute('data-filter'));
        });
    });
};

const initProjectModal = (projectsData) => {
    const modal = document.getElementById('project-modal');
    const modalCloseButton = document.getElementById('modal-close-button');
    const modalBackdrop = document.querySelector('[data-modal-backdrop]');

    if (!modal) {
        return;
    }

    const closeProjectModal = () => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    };

    const openProjectModal = (projectId) => {
        const project = projectsData[projectId];

        if (!project) {
            return;
        }

        const modalImageContainer = document.getElementById('modal-image-container');
        const modalMediaInfo = document.getElementById('modal-media-info');
        const modalCategory = document.getElementById('modal-category');
        const modalTitle = document.getElementById('modal-title-text');
        const modalDescription = document.getElementById('modal-description');
        const tagsContainer = document.getElementById('modal-tags');
        const githubLink = document.getElementById('modal-github');
        const demoLink = document.getElementById('modal-demo');

        if (!modalImageContainer || !modalMediaInfo || !modalCategory || !modalTitle || !modalDescription || !tagsContainer || !githubLink || !demoLink) {
            return;
        }

        modalImageContainer.innerHTML = '';
        modalImageContainer.style.display = 'block';
        modalMediaInfo.innerHTML = '';
        tagsContainer.innerHTML = '';

        const mediaSource = project.video_path || project.video_url;

        if (mediaSource) {
            const mediaUrl = project.video_path
                ? `${window.location.origin}/storage/${project.video_path}`
                : project.video_url;

            if (project.video_url && !project.video_path) {
                const iframe = document.createElement('iframe');
                iframe.src = getEmbedUrl(project.video_url);
                iframe.className = 'w-full h-full';
                iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                iframe.allowFullscreen = true;
                iframe.title = project.title;
                modalImageContainer.appendChild(iframe);
            } else {
                const video = document.createElement('video');
                video.src = mediaUrl;
                video.className = 'w-full h-full object-cover';
                video.controls = true;
                video.preload = 'metadata';
                modalImageContainer.appendChild(video);
            }
        } else if (project.image_path) {
            const image = document.createElement('img');
            image.src = `${window.location.origin}/storage/${project.image_path}`;
            image.alt = project.title;
            image.className = 'w-full h-full object-cover';
            modalImageContainer.appendChild(image);
        } else {
            modalImageContainer.style.display = 'none';
        }

        modalCategory.textContent = project.category || 'Category';
        modalTitle.textContent = project.title || 'Project Title';
        modalDescription.textContent = project.description || 'No description available.';

        if (Array.isArray(project.tags)) {
            project.tags.forEach((tag) => {
                const badge = document.createElement('span');
                badge.className = 'px-2.5 py-1 rounded bg-slate-950 border border-slate-800 text-[10px] font-semibold text-indigo-300';
                badge.textContent = tag;
                tagsContainer.appendChild(badge);
            });
        }

        if (Array.isArray(project.attachments) && project.attachments.length > 0) {
            const attachmentBlock = document.createElement('div');
            attachmentBlock.className = 'rounded-2xl border border-slate-800 bg-slate-950/70 p-4';
            attachmentBlock.innerHTML = `
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Project Attachments</h4>
                <div class="flex flex-wrap gap-2"></div>
            `;

            const list = attachmentBlock.querySelector('div.flex-wrap');

            project.attachments.forEach((file) => {
                const link = document.createElement('a');
                link.href = `${window.location.origin}/storage/${file}`;
                link.target = '_blank';
                link.rel = 'noopener';
                link.className = 'inline-flex items-center gap-2 rounded-full border border-slate-800 bg-slate-900 px-3 py-1.5 text-xs font-semibold text-slate-300 hover:text-white';
                link.innerHTML = `<i class="fa-solid fa-paperclip"></i> ${file.split('/').pop()}`;
                list.appendChild(link);
            });

            modalMediaInfo.appendChild(attachmentBlock);
        }

        githubLink.href = project.github_url || '#';
        githubLink.style.display = project.github_url ? 'inline-flex' : 'none';

        demoLink.href = project.demo_url || '#';
        demoLink.style.display = project.demo_url ? 'inline-flex' : 'none';

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    document.querySelectorAll('[data-project-id]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            openProjectModal(trigger.getAttribute('data-project-id'));
        });
    });

    modalCloseButton?.addEventListener('click', closeProjectModal);
    modalBackdrop?.addEventListener('click', closeProjectModal);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
            closeProjectModal();
        }
    });
};

const initPortfolio = () => {
    initMobileMenu();
    initPortfolioFilters();
    initProjectModal(getProjectsData());
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPortfolio);
} else {
    initPortfolio();
}

export { initPortfolio };
