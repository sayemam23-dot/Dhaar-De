// toast notification
function showToast(msg, duration) {
    duration = duration || 3000;
    var t = document.getElementById('toast');
    if (!t) return;
    t.textContent = msg;
    t.classList.add('show');
    clearTimeout(window._toastTimer);
    window._toastTimer = setTimeout(function() {
        t.classList.remove('show');
    }, duration);
}

// confetti effect for settle/forgive actions
function triggerConfetti() {
    var colors = ['#e85d2f', '#2eb87a', '#f5a623', '#74b9ff', '#a29bfe', '#fd79a8'];
    for (var i = 0; i < 70; i++) {
        var p = document.createElement('div');
        var size = Math.random() * 8 + 4;
        p.style.cssText = 'position:fixed;top:-10px;left:' + (Math.random() * 100) + 'vw;width:' + size + 'px;height:' + size + 'px;background:' + colors[Math.floor(Math.random() * colors.length)] + ';border-radius:' + (Math.random() > .5 ? '50%' : '2px') + ';animation:confettiFall ' + (Math.random() * 2 + 1.5) + 's linear forwards;animation-delay:' + (Math.random() * .5) + 's;pointer-events:none;z-index:9998;';
        document.body.appendChild(p);
        setTimeout(function() { p.remove(); }, 4000);
    }
}

// add confetti animation keyframes
(function() {
    var s = document.createElement('style');
    s.textContent = '@keyframes confettiFall { to { transform: translateY(110vh) rotate(720deg); opacity: 0; } }';
    document.head.appendChild(s);
})();

// show toast based on URL params
document.addEventListener('DOMContentLoaded', function() {
    var p = new URLSearchParams(window.location.search);
    if (p.get('added'))    showToast('✅ ধার সফলভাবে যোগ হয়েছে! 🙏');
    if (p.get('settled'))  { showToast('🎉 ধার পরিশোধ হয়েছে!'); triggerConfetti(); }
    if (p.get('forgiven')) { showToast('💚 ধার মাফ করা হয়েছে!'); triggerConfetti(); }
    if (p.get('saved'))    showToast('✅ পরিবর্তন সংরক্ষিত হয়েছে।');
    if (p.get('sent'))     showToast('📤 বার্তা পাঠানো হয়েছে।');
});

// filter debt rows by search query
function filterDebts(query) {
    var rows = document.querySelectorAll('.debt-row[data-search]');
    rows.forEach(function(row) {
        var txt = row.dataset.search.toLowerCase();
        row.style.display = txt.includes(query.toLowerCase()) ? '' : 'none';
    });
}

// switch between tabs
function switchTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(function(b) {
        b.classList.remove('active');
    });
    document.querySelectorAll('.tab-panel').forEach(function(p) {
        p.style.display = 'none';
    });
    document.querySelector('.tab-btn[data-tab="' + tabName + '"]').classList.add('active');
    var panel = document.getElementById('tab-' + tabName);
    if (panel) panel.style.display = 'block';
}

// confirm before submitting a form
function confirmAction(msg, form) {
    if (confirm(msg)) form.submit();
}

// format amount as taka
function formatTaka(n) {
    return '৳' + parseFloat(n).toLocaleString('en-BD', { minimumFractionDigits: 2 });
}

// animate progress bars on load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.progress-fill[data-pct]').forEach(function(bar) {
        setTimeout(function() {
            bar.style.width = bar.dataset.pct + '%';
        }, 200);
    });
});

// toggle payment form visibility
function togglePayForm() {
    var f = document.getElementById('payForm');
    if (f) f.style.display = f.style.display === 'none' ? 'block' : 'none';
}

// animate chart bars
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.bar[data-h]').forEach(function(bar) {
        bar.style.height = '0px';
        setTimeout(function() {
            bar.style.height = bar.dataset.h + 'px';
        }, 300);
    });
});
