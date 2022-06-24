// export default {
//     install(Vue, options) {
//         Vue.prototype.openLink = function(uri) {
//             window.location.href = '/' + uri
//         }
//     }
// }

function openLink( uri ) {
    window.location.href = '/' + uri
} 

export default openLink
