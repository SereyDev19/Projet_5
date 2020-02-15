class ReformatDate {

    constructor() {
    }

    init() {
    }

    abrev(array) {
        var res = []
        array.forEach(date => {
                var arraydate = date.split(' ')
                res.push(arraydate[0].slice(0, 3) + '. '+ arraydate[1] )
            }
        )
        return res
    }

}
