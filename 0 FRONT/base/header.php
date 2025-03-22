<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishtransfert</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,200..800&display=swap');
        :root {
            --red-100: #E84B4E;
            --red-110: #C4585A;
            --red-120: #D4040F;

            --white-100: #FFF;
            --white-110: #F1F1F1;
            --white-115: #F5F5F5;
            --white-120: #F5F5F5;
            --white-130: #CBCBCB;
            
            --black-100: #000;
            --black-110: #767676;
            --black-120: #4C4C4C;
            --black-130: #3E3E3E;

            --gray-100: #F5F5F5;
            --gray-110: #E4E4E4;
        }


        * {
            margin: 0;
            padding: 0;
            color: white;
            box-sizing: border-box;
            transition: all 100ms;
            font-family: "Bricolage Grotesque";
            text-decoration: none;
        }

        input {
            all: unset;
        }

        button {
            all: unset;
            cursor: pointer;
        }

        body {
            background-image: url("https://cdn.cosmos.so/1f89cd92-f0ca-4715-90f8-3b1e2e20b224?format=jpeg");
            background-repeat: no-repeat;
            background-position: 0 25%;
            background-size: cover;
        }

        /* Custom scrollbar styling */
        ::-webkit-scrollbar {
            width: 4px;
            padding: 0 8px;
            /* display: none; */
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--black-110);
            border-radius: 2px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--black-120);
        }

        /* Show scrollbar only when content is scrollable */
        *:hover::-webkit-scrollbar {
            display: block;
        }

        .fixed {
            position: fixed;
        }

        .right-20 {
            right: 20px;
        }

        .z-50 {
            z-index: 50;
        }


        .w-33 {
            width: 33px;
        }

        .w-80 {
            width: 80px;
        }

        .text-start {
            text-align: start;
        }

        .w-1-2{
            width: 50%;
        }

        .text-black {
            color: var(--black-100)
        }

        .text-red {
            color: var(--red-120)
        }


        .text-gray {
            color: var(--black-110);
        }

        .text-10 {
            font-size: 10px;
        }

        .text-12 {
            font-size: 12px;
        }

        .text-14 {
            font-size: 14px;
        }

        .text-15 {
            font-size: 15px;
        }

        .text-20 {
            font-size: 20px;
        }

        .radius-10 {
            border-radius: 10px;
        }
        .radius-20 {
            border-radius: 20px;
        }

        .opacity-0 {
            opacity: 0;
        }

        .opacity-1 {
            opacity: 1;
        }

        .radius-4 {
            border-radius: 4px;
        }
        .radius-5 {
            border-radius: 5px;
        }
        .border-2 {
            border: 2px solid;
        }

        .border-gray {
            border-color: var(--black-110);
        }

        .radius-t-10 {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .radius-b-10 {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .radius-l-10 {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .radius-r-10 {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .overflow-y-scroll {
            overflow-y: scroll;
        }

        .h-full{
            height: 100%;
        }

        .max-h-300 {
            max-height: 300px;
        }

        .bg-primary {
            background-color: var(--red-100);
        }

        .bg-white-115 {
            background-color: var(--white-115);
        }


        .pl-54 {
            padding-left: 54px;
        }

        .bg-white {
            background-color: var(--white-100);
        }

        .bg-gray {
            background-color: var(--white-120);
        }

        .bg-white-130 {
            background-color: var(--white-130)
        }

        .button.bg-primary:hover {
            background-color: var(--red-110);
        }

        .button.bg-white:hover {
            background-color: var(--white-110);
        }

        .button.bg-white.active {
            background-color: var(--white-120);
        }

        .flex {
            display: flex;
        }

        .flex-row {
            flex-direction: row;
        }

        .flex-col {
            flex-direction: column;
        }

        .p-15 {
            padding: 15px;
        }

        .gap-10 {
            gap: 10px;
        }

        .gap-8{
            gap: 8px;
        }

        .gap-14 {
            gap: 14px;
        }

        .text-center {
            text-align: center;
        }

        .w-198 {
            width: 198px;
        }

        .w-272 {
            width: 272px;
        }

        .w-738 {
            width: 738px;
        }

        .gap-20 {
            gap: 20px;
        }

        .gap-4 {
            gap: 4px;
        }

        .py-15 {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .py-8 {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .-bottom-60p{
            bottom: -60%;
        }

        .pointer {
            cursor: pointer;
        }

        .center-x {
            left: 50%;
            transform: translateX(-50%)
        }

        .center-y {
            top: 50%;
            transform: translateY(-50%)
        }

        .py-20 {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .pr-20 {
            padding-right: 20px;
        }

        .p-4 {
            padding: 4px;
        }

        .p-16 {
            padding: 16px;
        }

        .p-10 {
            padding: 10px;
        }

        .py-6 {
            padding-top: 6px;
            padding-bottom: 6px;
        }

        .p-8 {
            padding: 8px;
        }

        .p-10 {
            padding: 10px;
        }

        .px-20 {
            padding-left: 20px;
            padding-right: 20px;
        }

        .px-10 {
            padding-left: 10px;
            padding-right: 10px;
        }

        .px-8 {
            padding-left: 8px;
            padding-right: 8px;
        }

        .p-20 {
            padding: 20px;
        }

        .m-20 {
            margin-top: 20px;
        }

        .gap-30 {
            gap: 30px;
        }

        .gap-50 {
            gap: 50px;
        }

        .mr-31 {
            margin-right: 31px;
        }

        .underline {
            text-decoration: underline;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .text-wrap {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .w-13 {
            width: 13px;
        }
        .w-24 {
            width: 24px;
        }

        .w-px {
            width: 1px;
        }

        .h-px {
            height: 1px;
        }

        .w-max {
            width: max-content;
        }

        .lock-ratio {
            aspect-ratio: 1/1;
        }

        .w-full {
            width: -webkit-fill-available;
        }

        .h-34 {
            height: 34px;
        }

        .h-64 {
            height: 64px;
        }

        .h-103 {
            height: 103px;
        }

        .h-18 {
            height: 18px;
        }

        .w-18 {
            width: 18px;
        }

        .h-410 {
            height: 410px;
        }

        .box-shadow {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .h-full {
            height: 100%;
        }

        .items-center {
            align-items: center;
        }

        .items-start {
            align-items: start;
        }

        .self-end {
            align-self: end;
        }

        .ml-20 {
            margin-left: 20px;
        }

        .ml-auto {
            margin-left: auto;
        }

        .justify-end {
            justify-content: end;
        }

        .justify-center {
            justify-content: center;
        }

        .radius-12 {
            border-radius: 12px;
        }
        .input:hover {
            border-color: var(--black-120);
        }

        .relative {
            position: relative;
        }

        .input:has(input:focus) {
            border-color: var(--red-100);
        }

        input:focus {
            color: #000;
        }

        .justify-between {
            justify-content: space-between;
        }

        .absolute {
            position: absolute;
        }

        .bottom-10 {
            bottom: 10px;
        }

        .right-10 {
            right: 10px;
        }

        .page-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .page-left {
            position: absolute;
            top: 50%;
            left: 25%;
            transform: translate(-30%, -50%);
        }

        .page-left2 {
            position: absolute;
            top: 50%;
            left: 55%;
            transform: translate(-33%, -50%);
        }

        .page-left3 {
            position: absolute;
            top: 50%;
            left: 76%;
            transform: translate(-33%, -50%);
        }

        .left-20 {
            left: 20px;
        }

        .left-10 {
            left: 10px;
        }

        .right-0 {
            right: 0px;
        }

        .left-0 {
            left: 0px;
        }

        .top-0 {
            top: 0px;
        }

        .top-10 {
            top: 10px;
        }

        .top-8 {
            top: 8px;
        }

        .w-70 {
            width: 70px;
        }

        .w-171 {
            width: 171px;
        }
        .w-380 {
            width: 380px;
        }
        .w-561 {
            width: 561px;
        }

        .pl-33 {
            padding-left: 33px;
        }

        .pr-10 {
            padding-right: 10px;
        }

        .top-20 {
            top: 20px;
        }

        .pointer-events-none {
            pointer-events: none;
        }

        .w-332 {
            width: 332px;
        }

        .h-410 {
            height: 410px;
        }
        .list-none {
            list-style: none;
        }
        .top-200 {
            top: 200px;
        }

        .bold {
            font-weight: bold;
        }

        .gap-16 {
            gap: 15px;
        }

        .pb-15 {
            padding-bottom: 15px;
        }

        .w-312 {
            width: 312px;
        }

        .mx-10 {
            margin-left: 10px;
            margin-right: 10px;
        }

        .py-4 {
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .border-bottom-1 {
            border-bottom: 1px solid black;
        }

        .h-24 {
            height: 24px;
        }

        .h-13 {
            height: 13px;
        }

        .h-260 {
            height: 260px;
        }

        .top-radius-10 {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .button-bg-gray:hover {
            background-color: var(--gray-100);
        }

        .border-top {
            border-top: 2px solid var(--gray-110);
        }

        .border-radius20 {
            border-radius: 20px;
        }

        .bg-gray {
            background-color: var(--gray-100);
        }
    </style>
</head>
<body>
<?php
require_once "./0 FRONT/base/nav.php";
