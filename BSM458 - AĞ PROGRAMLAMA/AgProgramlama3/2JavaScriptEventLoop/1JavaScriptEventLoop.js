/**
 *
 * https://www.youtube.com/watch?v=6MXRNXXgP_0
 * http://latentflip.com/loupe/?code=CmNvbnNvbGUubG9nKCIxLiBNZXJoYWJhIik7CmNvbnNvbGUubG9nKCIyLiBE%2FG55YSIpOwoKc2V0VGltZW91dChmdW5jdGlvbiB0aW1lb3V0KCkgewogY29uc29sZS5sb2coIjMuNXNuIHNvbnJhKGVuIGF6KWJ1IG1lc2FqIGf2cvxudPxsZW5lY2VrIik7Cn0sIDUwMDApOwoKY29uc29sZS5sb2coIjQuIFllbmkgbWVzYWouIik7CgokLm9uKCJidXR0b24iLCAibW91c2VvdmVyIiwgZnVuY3Rpb24geCAoKXsgCiAgICBjb25zb2xlLmxvZygiNS4gbW91c2Ugb3ZlciIpIH0pOwogICAgCiQub24oImJ1dHRvbiIsICJjbGljayIsIGZ1bmN0aW9uIG9uY2xpY2sgKCl7IAogICAgY29uc29sZS5sb2coIjYuIG1vdXNlIGNsaWNrIikgfSk7!!!PGJ1dHRvbj5DbGljayBtZSE8L2J1dHRvbj4%3D
 *
 */


console.log("1. Merhaba");
console.log("2. Dünya");

setTimeout(function timeout() {   //timer API (event) (Tarayıcı içerisinde tanımlıdır (C++)- ayrı bir thread oluşturulur.)
// çalıştırılır ve onunla ilgili event listener(timeout)eklenir. Bu süre sonunda timer API olay yayar (event emiting) ve
    // timeout() listener bu olayın gereğini yerine getirmek için task queue içerisine eklenir.

    console.log("3.  5sn sonra(en az)bu mesaj görüntülenecek");
}, 5000);

console.log("4. Yeni mesaj.");

$.on("button", "mouseover", function x (){ // Event (mouseover API): farenin nese üzerine gelmesi event listener: onclick()
    console.log("5. mouse over") });

$.on("button", "click", function onclick (){ // Event: butona basılması event listener: onclick()
    console.log("6. mouse click") });