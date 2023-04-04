function getPluralString(value, words) {
    let number = value % 100;
    if (number > 19) {
        number = number % 10;
    }
    let result = value + ' ';
    switch (number) {
        case 1: result += words[0];
            break;
        case 2:
        case 3:
        case 4: result += words[1];
            break;
        default: result += words[2];
            break;
    }

    return result;
}