// NOTE: Extends lazysizes with background-image functionailty

// Functions
// --------------------------------
const loadOriginalBg = e => {
  const elem = e.target;

  // Stop if element is not lqip-background
  const isLQIPBackground = '\\blqip-background\\b'.test(elem.className);
  if (!isLQIPBackground) return;

  const src = elem.getAttribute('data-background-src');
  let srcset = elem.getAttribute('data-background-srcset');
  const original = new window.Image();

  // If there is a srcset specified, calculate src based on width of parentNode
  if (srcset) {
    // Get width of parentNode
    const parWidth = elem.parentNode.offsetWidth;
    const parHeight = elem.parentNode.offsetHeight;

    // Parse srcset as JSON
    srcset = JSON.parse(srcset);

    // Sort srcset from small to large size
    // @link https://goo.gl/2B1ACk
    srcset.sort((a, b) => (a.width > b.width) ? 1 : ((b.width > a.width) ? -1 : 0));

    for (let i = 0; i < srcset.length; i++) {
      const src = srcset[i];

      // Start loading src which size is large enough to fill parent width
      if (parWidth <= parseInt(src.width) && parHeight <= parseInt(src.height)) {
        original.src = src.url;

        // After the first match, stop the loop completely since this src
        // is already big enough for the user and we don't want to load a
        // bigger than necessary src
        break;
      }
    }

    // If no src is big enough for the screen, load the biggest one
    original.src = original.src || srcset[srcset.length - 1].url;
  } else if (src) {
    // If there is no srcset specified, get src from attribute
    original.src = src;
  }

  original.addEventListener('load', () => {
    elem.style.backgroundImage = `url('${original.src}')`;
  });
};

// Listen for beforeunveil event
// --------------------------------
document.addEventListener('lazybeforeunveil', loadOriginalBg);
