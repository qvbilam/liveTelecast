export function setCookie(name, value) {
  var oDate = new Date();
  oDate.setDate(oDate.getDate() + 1);
  document.cookie = name + "=" + value + 
  ";expires=" + oDate 
}

export function getCookie(name) {
  var str = document.cookie;
  var arr = str.split("; ");
  for (var i = 0; i < arr.length; i++) {
    var newArr = arr[i].split("=");
    if (newArr[0] == name) {
      return newArr[1];
    }
  }
}
export function removeCookie(name) {
  setCookie(name, 1, -1);
}