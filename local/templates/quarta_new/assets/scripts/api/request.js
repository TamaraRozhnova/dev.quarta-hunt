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
}