

// ---- cookie ---- //
function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }

function getCookie(cname) {
  let name = cname + "=";
  let ca = document.cookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
  
function cookieExist() {
  let session = getCookie("session");    
  if (session != "") {
    return true;
  } else {
    return false
  }
}
// ---- cookie ---- //


async function getOrSetSessionObj()
{
  let result;
  
  if(cookieExist())
  {
    const data = {
      session_id: getCookie('session')
    }

    const url = `https://steengede.com/interface.php?request=find_session`;
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data) 
    }
    result = await callServerByFetchReturnObject(url, options);
  } else {
    const url = `https://steengede.com/interface.php?request=create_session`;
    result = await callServerByFetchReturnObject(url);
    
    setCookie('session', result.session_id, 365);
  }

  return new Promise(function(resolve, reject) {
    resolve(result)
  })
}
