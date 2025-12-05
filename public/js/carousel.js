"use strict";

let next = document.querySelector(".next");
let prev = document.querySelector(".prev");

// Function để reset và trigger lại animation cho text
function triggerTextAnimation() {
    // Đợi một chút để đảm bảo DOM và frame transition đã bắt đầu
    setTimeout(() => {
        requestAnimationFrame(() => {
            const activeItem = document.querySelector(".slide .item:nth-child(2)");
            if (activeItem) {
                const content = activeItem.querySelector(".content");
                const name = content?.querySelector(".name");
                const des = content?.querySelector(".des");
                
                if (name && des) {
                    // Reset về trạng thái ban đầu
                    name.style.opacity = '0';
                    name.style.transform = 'translateY(20px)';
                    name.style.animation = 'none';
                    
                    des.style.opacity = '0';
                    des.style.transform = 'translateY(20px)';
                    des.style.animation = 'none';
                    
                    // Force reflow để đảm bảo reset được áp dụng
                    void name.offsetWidth;
                    void des.offsetWidth;
                    
                    // Trigger lại animation - bắt đầu cùng lúc với frame fade in
                    requestAnimationFrame(() => {
                        name.style.animation = 'fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.1s forwards';
                        des.style.animation = 'fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.1s forwards';
                    });
                }
            }
        });
    }, 50); // Delay nhỏ để đảm bảo frame transition đã bắt đầu
}

// Function chung để xử lý slide change
function handleSlideChange() {
    // Trigger animation sau khi DOM được cập nhật
    triggerTextAnimation();
}

next.addEventListener("click", function () {
    let items = document.querySelectorAll(".item");
    document.querySelector(".slide").appendChild(items[0]);
    handleSlideChange();
});

prev.addEventListener("click", function () {
    let items = document.querySelectorAll(".item");
    document.querySelector(".slide").prepend(items[items.length - 1]);
    handleSlideChange();
});
