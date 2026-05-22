/**
 * Wiring Start - Progressive Interactive JS
 */

document.addEventListener('DOMContentLoaded', () => {
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});

/**
 * Copies the composer install command from the hero install bar
 */
function copyInstallCommand() {
    const cmdText = document.getElementById('install-cmd').innerText;
    navigator.clipboard.writeText(cmdText).then(() => {
        const copyBtn = document.querySelector('.install-bar button.copy-btn');
        const originalSVG = copyBtn.innerHTML;
        
        // Success checkmark SVG
        copyBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#10b981" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        `;
        
        setTimeout(() => {
            copyBtn.innerHTML = originalSVG;
        }, 1500);
    }).catch(err => {
        console.error('Failed to copy text: ', err);
    });
}

/**
 * Switches the active command pane inside the terminal window
 * @param {string} tabName - 'quick-start', 'quality', or 'maker-cli'
 */
function switchTerminalTab(tabName) {
    // 1. Remove active state from all buttons
    const tabBtns = document.querySelectorAll('.terminal-tab-btn');
    tabBtns.forEach(btn => {
        btn.classList.remove('active');
        // If matched, activate it
        if (btn.getAttribute('onclick').includes(tabName)) {
            btn.classList.add('active');
        }
    });

    // 2. Hide all panes and display matching pane
    const panes = document.querySelectorAll('.terminal-pane');
    panes.forEach(pane => {
        pane.classList.remove('active');
    });

    const activePane = document.getElementById(`pane-${tabName}`);
    if (activePane) {
        activePane.classList.add('active');
    }
}

/**
 * Copies only the actual command lines from the active terminal pane, skipping prompt characters ($) and comments.
 */
function copyTerminalContent() {
    const activePane = document.querySelector('.terminal-pane.active');
    if (!activePane) return;

    // Get lines, extract only commands
    const commandLines = [];
    activePane.querySelectorAll('.terminal-line').forEach(line => {
        const commandEl = line.querySelector('.command');
        if (commandEl) {
            commandLines.push(commandEl.innerText);
        }
    });

    const copyText = commandLines.join('\n');
    navigator.clipboard.writeText(copyText).then(() => {
        const copyBtn = document.querySelector('.terminal-copy');
        const originalSVG = copyBtn.innerHTML;

        // Success checkmark SVG
        copyBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#10b981" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        `;

        setTimeout(() => {
            copyBtn.innerHTML = originalSVG;
        }, 1500);
    }).catch(err => {
        console.error('Failed to copy terminal content: ', err);
    });
}
