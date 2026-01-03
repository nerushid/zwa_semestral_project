<?php
/**
 * Main Page Filter Handler
 * 
 * Processes filter form submissions and redirects with
 * validated filter parameters in URL query string.
 * Implements POST-Redirect-GET pattern.
 * 
 * @package NestlyHomes
 * @subpackage Handlers
 */

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    try {
        require_once '../../includes/dbh.inc.php';
        require_once 'mainpage_model.inc.php';
        require_once 'mainpage_contr.inc.php';
        
        $filters = [];

        if (!empty($_GET['praha'])) {
            if (isValidPrahaFilter($_GET['praha'])) {
                $filters['praha'] = (int)$_GET['praha'];
            } else {
                unset($filters['praha']);
            }
        }

        if (!empty($_GET['district']) && isset($_GET['praha'])) {
            if (isValidDistrictFilter($_GET['district'], $_GET['praha'])) {
                $filters['district'] = $_GET['district'];
            } else {
                unset($filters['district']);
            }
        } 

        if (!empty($_GET['price_from'])) {
            if (isValidPriceFromFilter($_GET['price_from'])) {
                $filters['price_from'] = (int)$_GET['price_from'];
            } else {
                unset($filters['price_from']);
            }
        }

        if (!empty($_GET['price_to'])) {
            if (isValidPriceToFilter($_GET['price_to'])) {
                $filters['price_to'] = (int)$_GET['price_to'];
            } else {
                unset($filters['price_to']);
            }
        }
        
        if (!empty($_GET['area_from'])) {
            if (isValidAreaFromFilter($_GET['area_from'])) {
                $filters['area_from'] = (int)$_GET['area_from'];
            } else {
                unset($filters['area_from']);
            }
        }

        if (!empty($_GET['area_to'])) {
            if (isValidAreaToFilter($_GET['area_to'])) {
                $filters['area_to'] = (int)$_GET['area_to'];
            } else {
                unset($filters['area_to']);
            }
        }

        if (!empty($_GET['layouts'])) {
            $validLayouts = [];
            foreach ($_GET['layouts'] as $layout) {
                if (isValidLayoutFilter($layout)) {
                    $validLayouts[] = $layout;
                }
            }
            if (!empty($validLayouts)) {
                $filters['layouts'] = $validLayouts;
            }
        } else {
            unset($filters['layouts']);
        }

        $_SESSION['mainpage_data'] = $filters;
        $link = '';

        foreach ($filters as $filter => $value) {
            if (is_array($value)) {
                foreach ($value as $val) {
                    $link .= '&' . urlencode($filter) . '[]=' . urlencode($val);
                }
                continue;
            }
            $link .= '&' . urlencode($filter) . '=' . urlencode($value);
        }

        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        $sort = $_GET['sort'] ?? 'newest';
        if (isValidSortByFilter($sort)) {
            $link .= '&sort=' . htmlspecialchars($sort);
        }

        header("Location: ../index.php?" . ltrim($link, '&') . "&page=" . $page);
        die();
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
        die();
    }
} else {
    header("Location: ../index.php");
    die();
}