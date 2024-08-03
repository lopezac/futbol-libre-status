import React from "react";
import { createRoot } from "react-dom/client";
import {
    createBrowserRouter,
    RouterProvider,
} from "react-router-dom";

import HomePage from "./pages/Home";
import ReloadPage from "./pages/Reload";

const root = createRoot(document.getElementById("root"));
const router = createBrowserRouter([
    {
        path: "/",
        element: <HomePage />
    },
    {
        path: "reload",
        element: <ReloadPage />
    }
]);

root.render(
    <React.StrictMode>
        <RouterProvider router={router} />
    </React.StrictMode>
);