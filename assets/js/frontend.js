document.addEventListener('DOMContentLoaded', function() {
    const data = window.sio_afb_data;
    if (!data) return;

    const container = document.getElementById('sio-afb-container');
    if (!container) return;

    // Apply position and offsets
    if (data.position === 'bottom-right') {
        container.style.right = data.h_offset + 'px';
        container.style.bottom = data.v_offset + 'px';
    } else {
        container.style.left = data.h_offset + 'px';
        container.style.bottom = data.v_offset + 'px';
    }

    // Create Badge
    const badge = document.createElement('div');
    badge.id = 'sio-afb-badge';
    const badgeImg = document.createElement('img');
    badgeImg.src = data.badge_url;
    badgeImg.alt = 'Systeme.io Badge';
    badge.appendChild(badgeImg);
    container.appendChild(badge);

    // Create Menu
    const menu = document.createElement('div');
    menu.id = 'sio-afb-menu';
    const ul = document.createElement('ul');

    data.config.links.forEach(item => {
        const li = document.createElement('li');
        if (item.type === 'separator') {
            li.className = 'group-title';
            li.textContent = item.title;
            const sepTop = document.createElement('li');
            sepTop.className = 'separator';
            ul.appendChild(sepTop);
        } else {
            const a = document.createElement('a');
            a.textContent = item.title;
            
            // Construct URL
            let url = data.config.base_url + item.path;
            const params = [];
            if (data.affiliate_id) params.push(data.affiliate_id);
            if (data.tracking_code) params.push('tk=' + data.tracking_code);
            
            if (params.length > 0) {
                url += (url.includes('?') ? '&' : '?') + params.join('&');
            }
            
            a.href = url;
            a.target = '_blank';
            li.appendChild(a);
        }
        ul.appendChild(li);
    });

    menu.appendChild(ul);
    container.appendChild(menu);

    // Behavior
    const isMobile = () => window.innerWidth <= data.mobile_breakpoint;

    // Desktop: Hover
    container.addEventListener('mouseenter', () => {
        if (!isMobile()) {
            menu.classList.add('show');
        }
    });

    container.addEventListener('mouseleave', () => {
        if (!isMobile()) {
            menu.classList.remove('show');
        }
    });

    // Mobile: Tap
    badge.addEventListener('click', (e) => {
        if (isMobile()) {
            e.preventDefault();
            menu.classList.toggle('show');
        }
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!container.contains(e.target)) {
            menu.classList.remove('show');
        }
    });
});
