export default class Gate {
    constructor() {
        this.auth = window.auth
        this.authCompany = window.authCompany
    }
    isAdmin() {
        return this.auth.rule === 1;
    }
}
