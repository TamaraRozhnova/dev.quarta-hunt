window.addEventListener('DOMContentLoaded', () => {
    class Jobs {
        constructor() {
            this.jobsContainer = document.querySelector('.jobs__main');
            this.loader = document.querySelector('.loading');
            this.filter = {};

            this.createElements();
        }

        createElements() {
            this.selectVacancy = new Select({
                selector: '.select--vacancy',
                onSelect: () => this.handleChangeSelect()
            });

            this.selectSchedule = new Select({
                selector: '.select--schedule',
                onSelect: () => this.handleChangeSelect()
            });
        }

        handleChangeSelect() {
            const params = {
                vacancy: this.selectVacancy.getValue() ?? '',
                schedule: this.selectSchedule.getValue() ?? ''
            }
            this.getJobs(params);
        }

        getJobs(params) {
            this.setLoader(true);
            Request.fetchHtml(window.location.pathname, params)
                .then(html => {
                    if (!html) {
                        return;
                    }
                    this.insertHtml(html);
                })
                .finally(() => this.setLoader(false))
        }

        insertHtml(html) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const data = doc.querySelector('.jobs__main');
            this.jobsContainer.innerHTML = data.innerHTML;
        }

        setLoader(state = true) {
            if (state) {
                this.jobsContainer.style.display = 'none';
                this.loader.classList.add('loading--show');
            } else {
                this.loader.classList.remove('loading--show');
                this.jobsContainer.style.display = 'block';
            }
        }

    }

    new Jobs();
})