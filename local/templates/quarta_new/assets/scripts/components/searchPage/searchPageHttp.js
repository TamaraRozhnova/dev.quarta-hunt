class SearchPageHttp {

    static async fetchElements(params = {}) {

        const url = params.url

        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'text/html',
                'x-requested-with': 'Y'
            },
            body: JSON.stringify({
                params: params,
            })
        };
        try {
            // this.setLoader(true);
            const response = await fetch(url, options);
            return await response.text();
        } finally {
            // this.setLoader(false);
        }
    }

}