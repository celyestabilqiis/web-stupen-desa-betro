import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import { TextStyle, FontSize } from '@tiptap/extension-text-style';
import { Color } from '@tiptap/extension-color';
import Underline from '@tiptap/extension-underline';
import TextAlign from '@tiptap/extension-text-align';
import Highlight from '@tiptap/extension-highlight';
import Link from '@tiptap/extension-link';
import Image from '@tiptap/extension-image';
import { Table, TableRow, TableCell, TableHeader } from '@tiptap/extension-table';

window.initTipTapEditor = function (elementId, initialContent = '', uploadUrl = '', csrfToken = '') {
    const element = document.getElementById(elementId);
    if (!element) return null;

    const textarea = document.getElementById('isiInput');

    const editor = new Editor({
        element: element,
        extensions: [
            StarterKit.configure({
                heading: {
                    levels: [1, 2, 3],
                },
            }),
            TextStyle,
            FontSize,
            Color,
            Underline,
            Highlight.configure({ multicolor: true }),
            TextAlign.configure({
                types: ['heading', 'paragraph'],
            }),
            Link.configure({
                openOnClick: false,
                HTMLAttributes: {
                    target: '_blank',
                    rel: 'noopener noreferrer',
                    class: 'text-brand-700 underline',
                },
            }),
            Image.configure({
                inline: true,
                allowBase64: false,
                HTMLAttributes: {
                    class: 'rounded-xl max-w-full h-auto my-4 shadow-sm',
                },
            }),
            Table.configure({
                resizable: true,
                HTMLAttributes: {
                    class: 'tiptap-table',
                },
            }),
            TableRow,
            TableHeader,
            TableCell,
        ],
        content: initialContent,
        onUpdate({ editor }) {
            if (textarea) {
                textarea.value = editor.getHTML();
            }
            updateActiveStates();
        },
        onSelectionUpdate() {
            updateActiveStates();
        },
    });

    // Update active toolbar button states
    function updateActiveStates() {
        document.querySelectorAll('[data-tiptap-btn]').forEach(btn => {
            const action = btn.dataset.tiptapBtn;
            let isActive = false;

            if (action === 'bold') isActive = editor.isActive('bold');
            else if (action === 'italic') isActive = editor.isActive('italic');
            else if (action === 'underline') isActive = editor.isActive('underline');
            else if (action === 'strike') isActive = editor.isActive('strike');
            else if (action === 'blockquote') isActive = editor.isActive('blockquote');
            else if (action === 'bulletList') isActive = editor.isActive('bulletList');
            else if (action === 'orderedList') isActive = editor.isActive('orderedList');
            else if (action === 'align-left') isActive = editor.isActive({ textAlign: 'left' });
            else if (action === 'align-center') isActive = editor.isActive({ textAlign: 'center' });
            else if (action === 'align-right') isActive = editor.isActive({ textAlign: 'right' });
            else if (action === 'align-justify') isActive = editor.isActive({ textAlign: 'justify' });

            if (isActive) {
                btn.classList.add('bg-brand-100', 'text-brand-800', 'font-bold');
            } else {
                btn.classList.remove('bg-brand-100', 'text-brand-800', 'font-bold');
            }
        });

        // Heading selector update
        const headingSelect = document.getElementById('tiptapHeadingSelect');
        if (headingSelect) {
            if (editor.isActive('heading', { level: 1 })) headingSelect.value = 'h1';
            else if (editor.isActive('heading', { level: 2 })) headingSelect.value = 'h2';
            else if (editor.isActive('heading', { level: 3 })) headingSelect.value = 'h3';
            else headingSelect.value = 'p';
        }
    }

    // Bind toolbar buttons
    window.tiptapAction = function (action, param = null) {
        if (!editor) return;

        switch (action) {
            case 'undo': editor.chain().focus().undo().run(); break;
            case 'redo': editor.chain().focus().redo().run(); break;
            case 'bold': editor.chain().focus().toggleBold().run(); break;
            case 'italic': editor.chain().focus().toggleItalic().run(); break;
            case 'underline': editor.chain().focus().toggleUnderline().run(); break;
            case 'strike': editor.chain().focus().toggleStrike().run(); break;
            case 'clearFormatting': editor.chain().focus().unsetAllMarks().clearNodes().run(); break;
            case 'setHeading':
                if (param === 'p') editor.chain().focus().setParagraph().run();
                else if (param === 'h1') editor.chain().focus().toggleHeading({ level: 1 }).run();
                else if (param === 'h2') editor.chain().focus().toggleHeading({ level: 2 }).run();
                else if (param === 'h3') editor.chain().focus().toggleHeading({ level: 3 }).run();
                break;
            case 'setFontSize':
                if (param) editor.chain().focus().setFontSize(param).run();
                else editor.chain().focus().unsetFontSize().run();
                break;
            case 'setColor':
                if (param) editor.chain().focus().setColor(param).run();
                break;
            case 'setHighlight':
                if (param) editor.chain().focus().toggleHighlight({ color: param }).run();
                break;
            case 'align':
                editor.chain().focus().setTextAlign(param).run();
                break;
            case 'bulletList': editor.chain().focus().toggleBulletList().run(); break;
            case 'orderedList': editor.chain().focus().toggleOrderedList().run(); break;
            case 'blockquote': editor.chain().focus().toggleBlockquote().run(); break;
            case 'horizontalRule': editor.chain().focus().setHorizontalRule().run(); break;
            case 'insertLink': {
                const previousUrl = editor.getAttributes('link').href;
                const url = window.prompt('Masukkan URL tautan:', previousUrl || 'https://');
                if (url === null) return;
                if (url === '') {
                    editor.chain().focus().extendMarkRange('link').unsetLink().run();
                    return;
                }
                editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
                break;
            }
            case 'unsetLink':
                editor.chain().focus().unsetLink().run();
                break;
            case 'insertTable':
                editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run();
                break;
            case 'addColumnBefore': editor.chain().focus().addColumnBefore().run(); break;
            case 'addColumnAfter': editor.chain().focus().addColumnAfter().run(); break;
            case 'deleteColumn': editor.chain().focus().deleteColumn().run(); break;
            case 'addRowBefore': editor.chain().focus().addRowBefore().run(); break;
            case 'addRowAfter': editor.chain().focus().addRowAfter().run(); break;
            case 'deleteRow': editor.chain().focus().deleteRow().run(); break;
            case 'deleteTable': editor.chain().focus().deleteTable().run(); break;
            case 'uploadImage': {
                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.accept = 'image/jpeg,image/png,image/webp,image/jpg';
                fileInput.onchange = async () => {
                    const file = fileInput.files[0];
                    if (!file) return;

                    // Validasi batas ukuran 5 MB (5 * 1024 * 1024 = 5242880 bytes)
                    if (file.size > 5 * 1024 * 1024) {
                        const sizeMb = (file.size / (1024 * 1024)).toFixed(1).replace('.', ',');
                        alert(`Ukuran gambar terlalu besar (${sizeMb} MB). Maksimal 5 MB.`);
                        return;
                    }

                    const formData = new FormData();
                    formData.append('image', file);

                    try {
                        const res = await fetch(uploadUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });

                        const data = await res.json();
                        if (res.ok && data.url) {
                            editor.chain().focus().setImage({ src: data.url, alt: file.name }).run();
                        } else {
                            alert(data.message || 'Gagal mengunggah gambar ke server.');
                        }
                    } catch (err) {
                        alert('Terjadi kesalahan saat mengunggah gambar.');
                    }
                };
                fileInput.click();
                break;
            }
        }
    };

    // Sinkronisasi awal
    if (textarea) {
        textarea.value = editor.getHTML();
    }

    return editor;
};
