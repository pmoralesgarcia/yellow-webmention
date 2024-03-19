const targetUrl = window.location.href.toString().replace(/\/edit/, "");

const countUrl = "https://webmention.io/api/count.json?target=";
const mentionUrl = "https://webmention.io/api/mentions.jf2?target=";
const mFilter = "&wm-property=in-reply-to";

const defaultPhoto = "https://static.lifeofpablo.com/media/js/no-profile-photo.png";

async function fetchCounts(index, url) {
  const response = await fetch(url);
  const data = await response.json();
  showCounts(index, data);
}

async function fetchMentions(url) {
  const response = await fetch(url);
  const data = await response.json();
  showMentions(data.children);
}

function showCounts(index, data) {
  const countElements = {
    "wm_like": "like",
    "wm_ment": "mention",
    "wm_reply": "reply",
    "wm_repost": "repost",
    "wm_bkmk": "bookmark"
  };

  for (const key in countElements) {
    if (data.type[countElements[key]]) {
      document.getElementById(key + index).innerHTML = pluralize(data.type[countElements[key]], countElements[key], countElements[key] + "s");
    }
  }
}

function pluralize(num, singular, plural) {
  return num === 1 ? `${num} ${singular}` : `${num} ${plural}`;
}

function showMentions(mentions) {
  const panel = document.getElementById("mentionpanel");

  mentions.forEach(m => {
    const mDiv = document.createElement("div");
    mDiv.className = "webmention";
    panel.appendChild(mDiv);

    const mImg = document.createElement("img");
    mImg.src = m.author.photo ? m.author.photo : defaultPhoto;
    mImg.width = 64;
    mDiv.appendChild(mImg);

    const mInfo = document.createElement("div");
    mInfo.className = "wm_info";
    mDiv.appendChild(mInfo);

    const mAuth = m.author.url ? `<a href="${m.author.url}" class="m_author">${m.author.name}</a>` : `<span class="m_author">${m.author.name}</span>`;
    mInfo.innerHTML += mAuth;

    const mArt = `<a href="${m.url}" class="m_art">${m.name ? m.name : m.url}</a>`;
    mInfo.innerHTML += mArt;

    if (m.published) {
      const publishedDate = new Date(m.published);
      const mPub = `<time datetime="${m.published}" class="m_published">Published: ${publishedDate.toString()}</time>`;
      mInfo.innerHTML += mPub;
    }
  });
}

// Usage
fetchCounts(1, countUrl + targetUrl);
fetchMentions(mentionUrl + targetUrl);
