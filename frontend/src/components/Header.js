function Header() {
    return (
        <nav className="border-bottom p-4 shadow">
            <ul className="list-inline m-0 fs-5">
                <li className="list-inline-item">
                    <a className="text-decoration-none text-reset" href="index.php">Futbol Libre Status</a>
                </li>
                <li className="list-inline-item float-end">
                    <a className="text-decoration-none text-reset" href="reload.php">Recargar</a>
                </li>
            </ul>
        </nav>
    );
}

export default Header;