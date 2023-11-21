document.addEventListener("DOMContentLoaded", function(event) {

    const objReviewApi = new ReviewsApi();

    /** Общие функции */
    function create(htmlStr) {
        var frag = document.createDocumentFragment(),
            temp = document.createElement('div');
        temp.innerHTML = htmlStr;
        while (temp.firstChild) {
            frag.appendChild(temp.firstChild);
        }
        return frag;
    }

    /** Асинхронная отправка отзыва */
    async function sendReview(formData, groupWrapper) {
        objReviewApi.addReview(formData).then(data => {
            if (data) {
                if (groupWrapper != null) {
                    groupWrapper.innerHTML = 'Отзыв успешно отправлен!'
                }
            }
        })
    }

    /** Рейтинг */
    const groupWrapper = ".reviews-cabinet__form-group";

    const stars = document.querySelectorAll(".reviews-cabinet__form-star");
    const starsWrapper = ".reviews-cabinet__form-star-wrapper";
    const starsMeasoryLabel = ".reviews-cabinet__form-star-label";

    const startMeasory = {
        1 : "Ужасно",
        2 : "Плохо",
        3 : "Нормально",
        4 : "Хорошо",
        5 : "Отлично",
    }

    let currentActiveMeasory;

    stars.forEach((star) => {

        star.addEventListener('mouseover', (event) => {

            let currentStarHovered = event.target.closest('.star')
            let currentDataIndex = currentStarHovered.getAttribute('data-value')

            let currentMeasoryLabel = event.target.closest(groupWrapper).querySelector(`${starsMeasoryLabel}`)
            let currentMeasoryLabelHtml = event.target.closest(groupWrapper).querySelector(`${starsMeasoryLabel} span`)

            currentMeasoryLabelHtml.innerHTML = startMeasory[currentDataIndex]
            currentMeasoryLabel.classList.add('active')

            let previousElement = currentStarHovered.previousElementSibling;

            currentStarHovered.classList.add("hover")

            while (previousElement) {
                previousElement.classList.add("hover")
                previousElement = previousElement.previousElementSibling;
            }
            
        })

        star.addEventListener('mouseout', (event) => {

            let currentStarHovered = event.target.closest('.star')
            let currentDataIndex = currentStarHovered.getAttribute('data-value')

            let currentMeasoryLabel = event.target.closest(groupWrapper).querySelector(`${starsMeasoryLabel}`)
            let currentMeasoryLabelHtml = event.target.closest(groupWrapper).querySelector(`${starsMeasoryLabel} span`)

            currentMeasoryLabelHtml.innerHTML = startMeasory[currentDataIndex]
            currentMeasoryLabel.classList.remove('active')

            let previousElement = currentStarHovered.previousElementSibling;

            currentStarHovered.classList.remove("hover")

            while (previousElement) {
                previousElement.classList.remove("hover")
                previousElement = previousElement.previousElementSibling;
            }

            if (typeof currentActiveMeasory != 'undefined' || currentActiveMeasory != null) {
                currentMeasoryLabelHtml.innerHTML = currentActiveMeasory
            }
            
        })

        star.addEventListener('click', (event) => {

            let currentStarHovered = event.target.closest('.star')
            let currentDataIndex = currentStarHovered.getAttribute('data-value')

            let currentMeasoryLabel = event.target.closest(groupWrapper).querySelector(`${starsMeasoryLabel}`)

            currentMeasoryLabel.classList.add('active')
            currentMeasoryLabel.classList.add('clicked')

            currentActiveMeasory = startMeasory[currentDataIndex];

            let previousElement = currentStarHovered.previousElementSibling;
            let nextElement = currentStarHovered.nextElementSibling;

            currentStarHovered.classList.add("clicked")


            while (previousElement) {
                previousElement.classList.add("clicked")
                previousElement = previousElement.previousElementSibling;
            }

            while (nextElement) {
                nextElement.classList.remove("clicked")
                nextElement = nextElement.nextElementSibling;
            }
            
        })


    })


    /** Загрузка файлов */
    const uploadingWrapper = document.querySelectorAll(".reviews-cabinet__form-uploading-wrapper");
    const uploadingWrapperMainContainer = ".uploading-wrapper-main-container";
    const uploadingWrapperFilesContainer = ".reviews-cabinet__form-uploading-files-container";
    const uploadingWrapperFiles = ".reviews-cabinet__form-uploading-files";
    const formClass = ".reviews-cabinet__form";

    let uploadFiles = [];

    document.querySelectorAll(`${formClass} form`).forEach( (form) => {
        uploadFiles[form.id] = [];
    })

    uploadingWrapper.forEach((upload) =>  {

        /** Клик на форме "Загрузить фото" */
        upload.addEventListener('click', (event) => {
            let formUpload = event.target.closest(uploadingWrapperMainContainer).querySelector('.file-input')

            formUpload.click()
        })

        /** Событие на изменение/добавление файла */
        upload.querySelector('.file-input').addEventListener('change', (event) => {

            let filesListPublic = event.target.closest(uploadingWrapperMainContainer).querySelector(uploadingWrapperFiles)

            if (event.target.files.length != 0) {

                filesListPublic.innerHTML = '';

                let currentFormID = event.target.closest('form').getAttribute('id')

                for (let i = 0; i < event.target.files.length; i++) {
                    uploadFiles[currentFormID].push(event.target.files[i])
                }

                for (let i = 0; i < uploadFiles[currentFormID].length; i++) {
                    let htmlFragment = create(
                    `
                    <div data-number = '${i}' class = "reviews-cabinet__form-uploading-file">
                        ${uploadFiles[currentFormID][i].name}
                        <svg class = 'btn-delete' xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x input-file__file-remove">
                            <path d="M4.646 4.646a.5.5 0 01.708 0L8 7.293l2.646-2.647a.5.5 0 01.708.708L8.707 8l2.647 2.646a.5.5 0 01-.708.708L8 8.707l-2.646 2.647a.5.5 0 01-.708-.708L7.293 8 4.646 5.354a.5.5 0 010-.708z">
                            </path>
                        </svg>
                    </div>
                    `
                    )

                    filesListPublic.append(htmlFragment)
                }

                event.target.closest(uploadingWrapperMainContainer).querySelector(uploadingWrapperFilesContainer).style.display = 'flex'

            }

        })



    })

    /** Клик на иконку удаления файла */
    document.addEventListener('click', (event) => {
        
        if (event.target.closest('.btn-delete')) {

            let btnDelete = event.target.closest('.btn-delete');

            let currentFormID = btnDelete.closest('form').getAttribute('id')

            let currentFile = btnDelete.closest('div')
            let currentIndexFile = currentFile.getAttribute('data-number')
            
            if (currentIndexFile) {
                delete uploadFiles[currentFormID][currentIndexFile]
            }

            uploadFiles[currentFormID] = uploadFiles[currentFormID].filter(function (el) {
                return el != null;
            });

            if (uploadFiles[currentFormID].length == 0) {
                currentFile.closest(uploadingWrapperFilesContainer).style.display = 'none'   
            }

            currentFile.remove()

        }

    })

    /** Клик на Опубликовать отзыв */
    const btnGoPublish = document.querySelectorAll(".reviews-cabinet__form-btn")

    btnGoPublish.forEach((btn) => {

        btn.addEventListener("click", (event) => {
            event.preventDefault();

            const formData = new FormData(event.target.closest('form'));

            let currentFormID = event.target.closest('form').getAttribute('id')

            if (
                event.target.closest('form').querySelectorAll('.star.clicked').length > 0
            ) {

                formData.append('productId', event.target.closest('form').getAttribute('id'));
                formData.append('rating', event.target.closest('form').querySelectorAll('.star.clicked').length);

                if (uploadFiles[currentFormID].length != 0) {

                    for (let i = 0; i < uploadFiles[currentFormID].length; i++) {
                        formData.append('images[]' , uploadFiles[currentFormID][i])      
                    }

                } 

                sendReview(
                    formData, 
                    btn.closest('.reviews-cabinet__form')
                )

            }

        })

    })



});