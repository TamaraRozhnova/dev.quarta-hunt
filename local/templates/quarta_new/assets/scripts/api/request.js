class Request {

    static async fetch(url, data = null) {
        const options = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        };

        if (data) {
            options.method = 'POST';
            options.body = JSON.stringify(data);
        }

        const response = await fetch(url, options);
        return await response.json();
    }


    static async fetchWithFormData(url, formData) {
        console.log(formData.get('flaws'))
        const options = {
            method: 'POST',
            body: formData
        };
        const response = await fetch(url, options);
        return await response.json();
    }


    static async fetchHtml(url, params = null) {
        const options = {
            method: 'GET',
            headers: {
                'Content-Type': 'text/html',
                'x-requested-with': 'Y'
            },
        };

        if (params) {
            url += '?' + new URLSearchParams(params);
        }

        const response = await fetch(url, options);
        return await response.text();
    }
}