class ReformatDate {

    constructor() {
    }

    init() {
    }

    abrev(array) {
        var res = []
        array.forEach(date => {
                var arraydate = date.split(' ')
                res.push(arraydate[0].slice(0, 3) + '. ' + arraydate[1])
            }
        )
        return res
    }

    dayAndMonth(array) {
        var res = []
        array.forEach(date => {
                var newDate = new Date(date);
                var temp = newDate.getDay()
                var day = this.day(temp)
                res.push(day + ' ' + date.split('-')[2])
            }
        )
        return res
    }

    day(jour) {
        var res = ''
        switch (jour) {
            case 1:
                res = 'lundi';
                break;
            case 2:
                res = 'mardi';
                break;
            case 3:
                res = 'mercredi';
                break;
            case 4:
                res = 'jeudi';
                break;
            case 5:
                res = 'vendredi';
                break;
            case 6:
                res = 'samedi';
                break;
            case 0:
                res = 'dimanche';
                break;
        }
        return res

    }

}
