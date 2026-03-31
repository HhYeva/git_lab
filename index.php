<?php

/**
 * 1. LINEAR SEARCH (Գծային փնտրում)
 * Անցնում է զանգվածի վրայով հերթականությամբ:
 */
function linearSearch($array, $target) {
    for ($i = 0; isset($array[$i]); $i++) {
        if ($array[$i] == $target) return $i;
    }
    return -1;
}

/**
 * 2. BINARY SEARCH (Երկուական փնտրում)
 * Աշխատում է միայն սորտավորված զանգվածի հետ:
 */
function binarySearch($array, $target) {
    $low = 0;
    $high = 0;
    while (isset($array[$high])) $high++; // Քանակի հաշվում
    $high--;

    while ($low <= $high) {
        $mid = (int)(($low + $high) / 2);
        if ($array[$mid] == $target) return $mid;
        if ($target < $array[$mid]) $high = $mid - 1;
        else $low = $mid + 1;
    }
    return -1;
}

/**
 * 3. BINARY SEARCH TREE (BST)
 */
class BSTNode {
    public $value;
    public $left = null;
    public $right = null;
    public function __construct($value) { $this->value = $value; }
}

function insertBST($root, $value) {
    if ($root === null) return new BSTNode($value);
    if ($value < $root->value) $root->left = insertBST($root->left, $value);
    else $root->right = insertBST($root->right, $value);
    return $root;
}

function searchBST($node, $target) {
    if ($node === null || $node->value == $target) return $node;
    if ($target < $node->value) return searchBST($node->left, $target);
    return searchBST($node->right, $target);
}

/**
 * 4. TRIE (Prefix Tree)
 */
class TrieNode {
    public $children = [];
    public $isEndOfWord = false;
}

class Trie {
    private $root;
    public function __construct() { $this->root = new TrieNode(); }

    public function insert($word) {
        $node = $this->root;
        for ($i = 0; isset($word[$i]); $i++) {
            $char = $word[$i];
            if (!isset($node->children[$char])) $node->children[$char] = new TrieNode();
            $node = $node->children[$char];
        }
        $node->isEndOfWord = true;
    }

    public function search($word) {
        $node = $this->root;
        for ($i = 0; isset($word[$i]); $i++) {
            $char = $word[$i];
            if (!isset($node->children[$char])) return false;
            $node = $node->children[$char];
        }
        return $node->isEndOfWord;
    }
}

// --- ԹԵՍՏԱՎՈՐՈՒՄ ԵՎ ԺԱՄԱՆԱԿԻ ՉԱՓՈՒՄ ---

$data = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
$target = 70;

echo "--- Փնտրման ալգորիթմների թեստավորում ---\n\n";

// Linear Search
$s1 = microtime(true);
$r1 = linearSearch($data, $target);
$e1 = microtime(true);
echo "1. Linear Search: Index $r1, Time: " . ($e1 - $s1) . " sec\n";

// Binary Search
$s2 = microtime(true);
$r2 = binarySearch($data, $target);
$e2 = microtime(true);
echo "2. Binary Search: Index $r2, Time: " . ($e2 - $s2) . " sec\n";

// BST
$root = null;
foreach ($data as $val) $root = insertBST($root, $val);
$s3 = microtime(true);
$r3 = searchBST($root, $target);
$e3 = microtime(true);
echo "3. BST Search: " . ($r3 ? "Found" : "Not Found") . ", Time: " . ($e3 - $s3) . " sec\n";

// Trie
$trie = new Trie();
$trie->insert("apple");
$s4 = microtime(true);
$r4 = $trie->search("apple");
$e4 = microtime(true);
echo "4. Trie Search (apple): " . ($r4 ? "Found" : "Not Found") . ", Time: " . ($e4 - $s4) . " sec\n";

?>