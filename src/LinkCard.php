<?php

/**
 * 渲染链接卡片的函数，输出经过转义的 HTML 片段。
 * 支持自定义标题、描述、图标与链接信息。
 */

/**
 * 生成单个链接卡片 HTML
 *
 * @param string $url 链接地址
 * @param string $title 卡片标题
 * @param string $description 卡片描述
 * @param string $icon 图标（emoji 或简单文字）
 * @return string 转义后的 HTML 片段
 */
function render_link_card(string $url, string $title, string $description, string $icon = '🔗'): string
{
    $safeUrl = htmlspecialchars($url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeDesc = htmlspecialchars($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $safeIcon = htmlspecialchars($icon, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    $html = '<div class="link-card">' . PHP_EOL;
    $html .= '    <a href="' . $safeUrl . '" target="_blank" rel="noopener noreferrer">' . PHP_EOL;
    $html .= '        <span class="card-icon">' . $safeIcon . '</span>' . PHP_EOL;
    $html .= '        <div class="card-content">' . PHP_EOL;
    $html .= '            <span class="card-title">' . $safeTitle . '</span>' . PHP_EOL;
    $html .= '            <span class="card-description">' . $safeDesc . '</span>' . PHP_EOL;
    $html .= '        </div>' . PHP_EOL;
    $html .= '    </a>' . PHP_EOL;
    $html .= '</div>' . PHP_EOL;

    return $html;
}

/**
 * 批量生成链接卡片 HTML（按列表渲染）
 *
 * @param array $cards 每项包含 url, title, description, icon
 * @return string 拼接后的 HTML
 */
function render_link_cards(array $cards): string
{
    $output = '<div class="link-card-list">' . PHP_EOL;

    foreach ($cards as $card) {
        $url = $card['url'] ?? '#';
        $title = $card['title'] ?? '未命名链接';
        $desc = $card['description'] ?? '';
        $icon = $card['icon'] ?? '🔗';

        $output .= render_link_card($url, $title, $desc, $icon);
    }

    $output .= '</div>' . PHP_EOL;

    return $output;
}

/**
 * 静态示例数据：包含默认站点与关键词展示
 *
 * @return array
 */
function get_default_link_cards(): array
{
    return [
        [
            'url' => 'https://zhcn-ng.com',
            'title' => 'ng体育',
            'description' => '探索 ng体育 相关资讯与平台动态',
            'icon' => '🏟️',
        ],
        [
            'url' => 'https://zhcn-ng.com/about',
            'title' => '关于我们',
            'description' => '了解 ng体育 的使命与团队',
            'icon' => 'ℹ️',
        ],
        [
            'url' => 'https://zhcn-ng.com/contact',
            'title' => '联系方式',
            'description' => '与 ng体育 取得联系',
            'icon' => '📧',
        ],
    ];
}

// 示例用法（可直接运行 php 文件查看输出）
if (!debug_backtrace()) {
    header('Content-Type: text/html; charset=utf-8');
    echo '<!DOCTYPE html><html lang="zh-CN"><head><meta charset="UTF-8"><title>链接卡片示例</title>';
    echo '<style>
        .link-card-list { max-width: 600px; margin: 2em auto; font-family: sans-serif; }
        .link-card { border: 1px solid #ddd; border-radius: 8px; margin-bottom: 12px; transition: box-shadow 0.2s; }
        .link-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .link-card a { display: flex; align-items: center; text-decoration: none; color: inherit; padding: 12px; }
        .card-icon { font-size: 2em; margin-right: 12px; }
        .card-content { display: flex; flex-direction: column; }
        .card-title { font-weight: bold; font-size: 1.1em; }
        .card-description { color: #666; font-size: 0.9em; margin-top: 4px; }
    </style></head><body>';

    $cards = get_default_link_cards();
    echo render_link_cards($cards);

    echo '</body></html>';
}