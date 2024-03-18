const targetUrl = window.location.href.toString().replace(/\/edit/, "");

// jsonp=f option to disable json return
const countUrl   = "https://webmention.io/api/count.json?target=";
const mentionentionUrl = "https://webmention.io/api/mentions.jf2?target=";
const mentionfilter = "&wm-property=in-reply-to";

const defaultPhoto = "https://aaronparecki.com/assets/images/no-profile-photo.png"

fetch(countUrl+targetUrl)
  .then(response => {return(response.text());})
  .then(myJson => {showCounts(1,JSON.parse(myJson));});

fetch(mentionUrl+targetUrl)
  .then(response => {return(response.text());})
  .then(myJson => {showMentions(JSON.parse(myJson));});

function showCounts(index, data) {
  // Add code to hide mention panel if data.count = 0
  if (data.type.like) { document.getElementById("webmentionLike"+index).innerHTML = data.type.like; }
  if (data.type.mention) { document.getElementById("webmentionMention"+index).innerHTML = data.type.mention; }
  if (data.type.reply) {
      document.getElementById("wm_reply"+index).innerHTML =
        pluralize(data.type.reply,"reply","replies");
  }
  if (data.type.repost) {
    document.getElementById("wm_repost"+index).innerHTML =
      pluralize(data.type.repost,"repost","reposts");
  }
  if (data.type.bookmark) { document.getElementById("wm_bkmk"+index).innerHTML = data.type.bookmark; }
}

function pluralize(num,singular,plural) {
  if (num == 1) return num + " " + singular;
  return num + " " + plural;
}

function showMentions(mentions) {
  const panel = document.getElementById("mentionpanel");
  for(i=0;i<mentions.children.length;i++) {

    const mention = mentions.children[i];

    const mentionMentionDiv = document.createElement("div");
    mentionDiv.className = "webmention";
    panel.appendChild(mentionDiv);

    const mentionentionImg = document.createElement("div");
    if (m.author.photo) {
      mentionImg.setAttribute("src",m.author.photo);
    }
    else {
      mentionImg.setAttribute("src",defaultPhoto);
    }
    mentionImg.setAttribute("width","64");
    mentionDiv.appendChild(mentionImg);

    const mentionentionInfo = document.createElement("div");
    mentionInfo.className = "wmentionInfo";
    mentionDiv.appendChild(mentionInfo);

    // First line is author's name, liked to author's web site if present
    if (m.author.url) {
      const mention_auth = document.createElement("a");
      m_auth.href = m.author.url;
      if (m.author.name) {
        m_auth.innerHTML = m.author.name;
      }
      m_auth.className = "m_author";
      mentionInfo.appendChild(m_auth);

    }
    else {
      if (m.author.name) {
        const mention_auth = document.createElement("span");
        m_auth.innerHTML = m.author.name;
        m_auth.className = "m_author";
        mentionInfo.appendChild(m_auth);
      }
    }

    // Second line = name of post linked to post URL, though
    // if no name then is just URL
    const mention_art = document.createElement("a");
    m_art.href = m.url;
    if (m.name) {
      m_art.innerHTML = m.name;
    }
    else {
      m_art.innerHTML = m.url;
    }
    mentionInfo.appendChild(m_art);

    if (m.published) {
      const date = new Date(m.published);
      const mentionmentionPub = document.createElement("TIME");
      mentionPub.datetime = m.published;
      mentionPub.innerHTML = "Published: " + d.toString();
      mentionPub.className = "mentionPublished";
      mentionInfo.appendChild(mentionPub);
    }
  }
}

