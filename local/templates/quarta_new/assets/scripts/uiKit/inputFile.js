class InputFile {

    constructor(
        data = {
            wrapperSelector: '.input-file',
            maxSize: 1024 ** 2 * 5,
            maxFiles: 1,
            showAddedFiles: true,
        }
    ) {
        this.wrapperSelector = data.wrapperSelector;
        this.wrapper = document.querySelector(this.wrapperSelector);
        this.inputFile = this.wrapper.querySelector('input[type="file"]');
        this.description = this.wrapper.querySelector('.input-file__description');
        this.maxSize = data.maxSize;
        this.maxFiles = data.maxFiles;
        this.showAddedFiles = data.showAddedFiles;

        this.files = [];
        this.hangEvents();
    }

    getValue() {
        return this.files;
    }

    hangEvents() {
        this.handleLoadFile();
    }

    handleLoadFile() {
        this.inputFile.addEventListener('change', (event) => {
            const files = event.target.files;
            if (!files) {
                return;
            }
            Array.from(files).forEach((file) => {
                if (file.size > this.maxSize) {
                    return;
                }
                if (!this.checkMaxCountFiles()) {
                    return;
                }
                this.files.push(file);
            });
            this.updateFileList();
        })
    }

    updateFileList() {
        if (!this.showAddedFiles) {
            return;
        }
        let fileList = this.wrapper.querySelector('.input-file__files');
        if (!fileList) {
            this.wrapper.insertAdjacentHTML('beforeend', this.createFileListHtml());
            fileList = this.wrapper.querySelector('.input-file__files');
        }
        fileList.innerHTML = this.files.map((file, index) => this.createAddedFileHtml(file.name, index)).join('');
        this.changeDescriptionStyle();
        this.hangDeleteFilesEvent();
    }

    hangDeleteFilesEvent() {
        const filesElements = this.wrapper.querySelectorAll('.input-file__file');
        filesElements.forEach(element => {
            const button = element.querySelector('.input-file__file-remove');
            button.addEventListener('click', () => {
                const fileId = button.dataset.id;
                this.files = this.files.filter((file, index) => index != fileId);
                this.updateFileList();
            });
        });
    }

    createFileListHtml() {
        return (
            `<div class="input-file__files--list">
                <p class="input-file__added-files">Добавленные файлы:</p>
                <div class="input-file__files"></div>
            </div>`
        )
    }

    createAddedFileHtml(filename, index) {
        return (
            `<div class="input-file__file">
                ${filename}
                <svg class="input-file__file-remove bi bi-x" data-id="${index}" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
            </div>`
        )
    }

    checkMaxCountFiles() {
        return this.files.length < this.maxFiles;
    }

    changeDescriptionStyle() {
        const newFileIsLastToAllowToLoad = this.files.length === this.maxFiles;
        if (newFileIsLastToAllowToLoad) {
            this.wrapper.classList.add('input-file--max-count-reached');
            this.description.innerHTML = 'Достигнуто максимальное колличество файлов';
        } else {
            this.wrapper.classList.remove('input-file--max-count-reached');
            this.description.innerHTML = `Прикрепить файл (не более ${this.maxSize / 1024 ** 2}MB)`;
        }
    }

}