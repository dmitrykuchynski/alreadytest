export default function getHeaderHeight(){
    const header = document.querySelector('.header')
    return  header ? parseFloat(header.getBoundingClientRect().height) +  parseFloat(header.getBoundingClientRect().y): 0;
}


