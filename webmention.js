var target_url = "<?php echo $link ?>";
var target_url1 = "https://www.disquisitioner.com/posts/post-darkmode/";

// jsonp=f option to disable json return
var count_url   = "https://webmention.io/api/count.json?target=";
var mention_url = "https://webmention.io/api/mentions.jf2?target=";
var mfilter = "&wm-property=in-reply-to";

var defaultphoto = "https://aaronparecki.com/assets/images/no-profile-photo.png"

fetch(count_url+target_url)
  .then(response => {return(response.text());})
  .then(myJson => {showCounts(1,JSON.parse(myJson));});

fetch(mention_url+target_url)
  .then(response => {return(response.text());})
  .then(myJson => {showMentions(JSON.parse(myJson));});

function showCounts(index, data) {
  // Add code to hide mention panel if data.count = 0
  if(data.type.like) { document.getElementById("wm_like"+index).innerHTML = data.type.like; }
  if(data.type.mention) { document.getElementById("wm_ment"+index).innerHTML = data.type.mention; }
  if(data.type.reply) {
      document.getElementById("wm_reply"+index).innerHTML =
        pluralize(data.type.reply,"reply","replies");
  }
  if(data.type.repost) {
    document.getElementById("wm_repost"+index).innerHTML =
      pluralize(data.type.repost,"repost","reposts");
  }
  if(data.type.bookmark) { document.getElementById("wm_bkmk"+index).innerHTML = data.type.bookmark; }
}

function pluralize(num,singular,plural) {
  if(num == 1) return num + " " + singular;
  return num + " " + plural;
}

function showMentions(mentions) {
  var panel = document.getElementById("mentionpanel");
  for(i=0;i<mentions.children.length;i++) {

    var m = mentions.children[i];

    var m_div = document.createElement("DIV");
    m_div.className = "webmention";
    panel.appendChild(m_div);

    var m_img = document.createElement("IMG");
    if(m.author.photo) {
      m_img.setAttribute("src",m.author.photo);
    }
    else {
      m_img.setAttribute("src",defaultphoto);
    }
    m_img.setAttribute("width","64");
    m_div.appendChild(m_img);

    var m_info = document.createElement("DIV");
    m_info.className = "wm_info";
    m_div.appendChild(m_info);

    // First line is author's name, liked to author's web site if present
    if(m.author.url) {
      var m_auth = document.createElement("A");
      m_auth.href = m.author.url;
      if(m.author.name) {
        m_auth.innerHTML = m.author.name;
      }
      m_auth.className = "m_author";
      m_info.appendChild(m_auth);

    }
    else {
      if(m.author.name) {
        var m_auth = document.createElement("SPAN");
        m_auth.innerHTML = m.author.name;
        m_auth.className = "m_author";
        m_info.appendChild(m_auth);
      }
    }

    // Second line = name of post linked to post URL, though
    // if no name then is just URL
    var m_art = document.createElement("A");
    m_art.href = m.url;
    if(m.name) {
      m_art.innerHTML = m.name;
    }
    else {
      m_art.innerHTML = m.url;
    }
    m_info.appendChild(m_art);

    if(m.published) {
      var d = new Date(m.published);
      var m_pub = document.createElement("TIME");
      m_pub.datetime = m.published;
      m_pub.innerHTML = "Published: " + d.toString();
      m_pub.className = "m_published";
      m_info.appendChild(m_pub);
    }
  }
}

