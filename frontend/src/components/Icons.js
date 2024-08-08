function GithubIcon() {
    return (<i className="bi bi-github" style={{"fontSize": "1.8rem"}}></i>);
}

function EmailIcon() {
    return (<i className="bi bi-envelope-fill" style={{"fontSize": "1.8rem"}}></i>);
}

function SuccessIcon() {
    return (<i className="bi bi-check-circle-fill" style={{color: "green", fontSize: "2.3rem"}}></i>);
}

function AlertIcon() {
    return (<i className="bi bi-exclamation-circle-fill" style={{color: "red", fontSize: "2.3rem"}}></i>);
}

export { GithubIcon, EmailIcon, AlertIcon, SuccessIcon };